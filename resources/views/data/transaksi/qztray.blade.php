
        <button type="button" class="btn btn-primary" onclick="cetakQz()" id="btnCetak">
            <i class="fas fa-print"></i> Cetak Nota
        </button>
        
        @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sha.js/2.4.11/sha.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsrsasign@10.5.25/lib/jsrsasign-all-min.js"></script>

<script>
    const PRINT_URL = @json(route($rp.'.transaksi.print-qz', $transaksi -> id));
    const CSRF_TOKEN = @json(csrf_token());

    /* ── LOG HELPERS ──────────────────────────────────────────────── */
    function openLog() {
        document.getElementById('printLogPanel').classList.add('visible');
        document.getElementById('logBody').innerHTML = '';
        document.getElementById('logBar').style.width = '0%';
    }

    function closeLog() {
        document.getElementById('printLogPanel').classList.remove('visible');
    }

    function setProgress(pct) {
        document.getElementById('logBar').style.width = pct + '%';
    }

    function setDot(state) {
        document.getElementById('logDot').className = 'log-dot' + (state !== 'idle' ? ' ' + state : '');
    }

    function log(msg, type = 'info') {
        const icons = {
            step: '▶',
            ok: '✔',
            err: '✘',
            warn: '⚠',
            info: '·',
            dim: ' '
        };
        const now = new Date().toLocaleTimeString('id-ID', {
            hour12: false
        });
        const body = document.getElementById('logBody');
        const line = document.createElement('div');
        line.className = `log-line log-${type}`;
        line.innerHTML =
            `<span class="log-time">${now}</span>` +
            `<span class="log-icon">${icons[type] ?? '·'}</span>` +
            `<span class="log-msg">${String(msg).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</span>`;
        body.appendChild(line);
        body.scrollTop = body.scrollHeight;
    }

    /* ── QZ TRAY SECURITY (skip cert — dev/LAN) ──────────────────── */
    /* ── QZ TRAY SECURITY (signed — production, no popup) ─────────── */
    const QZ_CERT_URL = @json(route('qz.certificate'));
    const QZ_SIGN_URL = @json(route('qz.sign'));

    qz.security.setCertificatePromise(function(resolve, reject) {
        fetch(QZ_CERT_URL)
            .then(res => res.text())
            .then(resolve)
            .catch(reject);
    });

    qz.security.setSignatureAlgorithm('SHA256');

    qz.security.setSignaturePromise(function(toSign) {
        return function(resolve, reject) {
            fetch(QZ_SIGN_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'text/plain',
                    },
                    body: JSON.stringify({
                        request: toSign
                    }),
                })
                .then(res => res.text())
                .then(resolve)
                .catch(reject);
        };
    });

    /* ── FUNGSI UTAMA CETAK ───────────────────────────────────────── */
    async function cetakQz() {
        const btn = document.getElementById('btnCetak');
        btn.disabled = true;
        document.getElementById('httpsAlert').classList.remove('visible');

        openLog();
        setDot('active');

        // ── STEP 1: Koneksi QZ Tray ────────────────────────────────────
        log('Mengecek koneksi QZ Tray...', 'step');

        try {
            if (qz.websocket.isActive()) {
                log('QZ Tray sudah aktif ✔', 'ok');
            } else {
                const proto = location.protocol === 'https:' ? 'wss' : 'ws';
                log(`Menghubungkan ke ${proto}://localhost:8181...`, 'dim');
                await qz.websocket.connect({
                    retries: 2,
                    delay: 1,
                    usingSecure: location.protocol === 'https:',
                });
                log('QZ Tray terhubung ✔', 'ok');
            }
        } catch (err) {
            log('QZ Tray gagal konek: ' + err.message, 'err');
            if (location.protocol === 'https:') {
                log('Buka https://localhost:8181 di tab baru lalu trust cert-nya.', 'warn');
                document.getElementById('httpsAlert').classList.add('visible');
            } else {
                log('Pastikan QZ Tray sudah berjalan di taskbar.', 'warn');
            }
            finishLog(false, btn);
            return;
        }

        setProgress(25);

        // ── STEP 2: Fetch ESC/POS dari server ─────────────────────────
        log('Mengambil data ESC/POS dari server...', 'step');

        let payload;
        try {
            const res = await fetch(PRINT_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
            });

            log(`Server → HTTP ${res.status} ${res.statusText}`, res.ok ? 'dim' : 'warn');
            payload = await res.json();

            if (!payload.success) {
                throw new Error(payload.message ?? 'Unknown error dari server');
            }

            const bytes = Math.round(atob(payload.data).length);
            log(`ESC/POS OK — ${bytes} bytes, printer: "${payload.printer}"`, 'ok');

        } catch (err) {
            log('Gagal ambil data dari server: ' + err.message, 'err');
            log('Cek storage/logs/laravel.log di server untuk detail.', 'dim');
            finishLog(false, btn);
            return;
        }

        setProgress(50);

        // ── STEP 3: Cari printer ───────────────────────────────────────
        const printerName = payload.printer ?? 'POS58';
        log(`Mencari printer: "${printerName}"...`, 'step');

        let resolvedPrinter;
        try {
            const found = await qz.printers.find(printerName);
            resolvedPrinter = Array.isArray(found) ? found[0] : found;
            log(`Printer ditemukan: "${resolvedPrinter}" ✔`, 'ok');
        } catch {
            log(`Printer "${printerName}" tidak ditemukan, mencoba printer default...`, 'warn');
            try {
                resolvedPrinter = await qz.printers.getDefault();
                log(`Printer default: "${resolvedPrinter}"`, 'warn');
            } catch (e) {
                log('Tidak ada printer tersedia: ' + e.message, 'err');
                log('Pastikan printer sudah terpasang dan terinstall di Windows.', 'dim');
                finishLog(false, btn);
                return;
            }
        }

        setProgress(75);

        // ── STEP 4: Kirim ke printer ───────────────────────────────────
        log(`Mengirim data ke "${resolvedPrinter}"...`, 'step');

        try {
            const config = qz.configs.create(resolvedPrinter, {
                rawCommandsOnly: true,
                encoding: 'CP437', // umum untuk printer thermal ESC/POS
            });

            await qz.print(config, [{
                type: 'raw',
                format: 'base64',
                data: payload.data,
            }]);

            setProgress(100);
            log(`Nota berhasil dicetak di "${resolvedPrinter}" ✔`, 'ok');
            finishLog(true, btn);

        } catch (printErr) {
            log('Gagal kirim ke printer: ' + printErr.message, 'err');
            if (printErr.message.includes('denied') || printErr.message.includes('permission')) {
                log('Permission ditolak — cek pengaturan site di QZ Tray.', 'warn');
            } else if (printErr.message.includes('offline')) {
                log('Printer offline — cek kabel USB atau koneksi LAN printer.', 'warn');
            }
            finishLog(false, btn);
        }
    }

    /* ── FINISH ───────────────────────────────────────────────────── */
    function finishLog(success, btn) {
        btn.disabled = false;
        setDot(success ? 'idle' : 'error');
        log('─────────────────────────────────────', 'dim');
        showToast(
            success ? '✔ Nota berhasil dicetak!' : '✘ Cetak gagal — lihat log di atas',
            success ? 'success' : 'error'
        );
    }

    function showToast(msg, type = 'success') {
        document.getElementById('toastNotif')?.remove();
        const t = document.createElement('div');
        t.id = 'toastNotif';
        t.style.cssText = `
        position:fixed; bottom:24px; right:24px; z-index:99999;
        background:${type === 'success' ? '#065f46' : '#991b1b'};
        color:white; padding:16px 24px; border-radius:10px;
        font-size:15px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.3);
        max-width:400px; line-height:1.5;
    `;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t?.remove(), 6000);
    }

    /* ── AUTO PRINT ───────────────────────────────────────────────── */
    @if(session('auto_print'))
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => cetakQz(), 800);
    });
    @endif
</script>
@endpush