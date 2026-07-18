@extends('layouts.app')

@section('title', 'Detail Transaksi #' . $transaksi->no_nota)
@section('breadcrumb', 'Transaksi / Detail')
@section('page-title', 'Detail Transaksi')

@push('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .info-card {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .info-card-header {
        padding: 14px 20px;
        background: var(--bg-body);
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
    }
    .info-card-body { padding: 20px; }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
        gap: 12px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-label { color: var(--text-secondary); font-weight: 600; flex-shrink: 0; }
    .info-row-value { color: var(--text-primary); text-align: right; }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-badge.selesai { background: #d1fae5; color: #065f46; }
    .status-badge.batal   { background: #fee2e2; color: #991b1b; }
    .metode-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: rgba(47,50,145,.08);
        color: var(--primary);
    }
    .produk-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .produk-table thead tr { background: var(--bg-body); }
    .produk-table th {
        padding: 12px 16px;
        font-weight: 700;
        color: var(--text-secondary);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .produk-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    .produk-table tbody tr:last-child td { border-bottom: none; }
    .produk-table tbody tr:hover { background: rgba(47,50,145,.03); }
    .summary-box {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 24px;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row.grand-total {
        background: var(--primary);
        color: white;
        font-size: 18px;
        font-weight: 700;
        padding: 18px 24px;
    }
    .poin-row { background: #fffbeb; border-left: 4px solid #f59e0b; }

    /* ── Print Log Panel ── */
    #printLogPanel {
        display: none;
        background: #0f1117;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,.3);
    }
    #printLogPanel.visible { display: block; }
    .log-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        background: #1a1d27;
        border-bottom: 1px solid #2d3148;
    }
    .log-header-left { display: flex; align-items: center; gap: 10px; }
    .log-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: #6b7280;
        transition: background .3s;
    }
    .log-dot.active { background: #22c55e; animation: pulse-dot 1s ease-in-out infinite; }
    .log-dot.error  { background: #ef4444; animation: none; }
    .log-title { color: #e5e7eb; font-size: 13px; font-weight: 600; font-family: monospace; }
    .log-close {
        background: none; border: none; color: #6b7280;
        font-size: 18px; cursor: pointer; padding: 0 4px; line-height: 1;
    }
    .log-close:hover { color: #e5e7eb; }
    #logBody {
        padding: 14px 18px;
        font-family: 'Courier New', monospace;
        font-size: 12.5px;
        line-height: 1.9;
        max-height: 280px;
        overflow-y: auto;
        color: #9ca3af;
    }
    .log-line { display: flex; gap: 10px; }
    .log-time { color: #4b5563; flex-shrink: 0; }
    .log-icon { flex-shrink: 0; }
    .log-msg  { color: #d1d5db; }
    .log-ok   .log-msg { color: #4ade80; }
    .log-err  .log-msg { color: #f87171; }
    .log-warn .log-msg { color: #fbbf24; }
    .log-info .log-msg { color: #60a5fa; }
    .log-dim  .log-msg { color: #6b7280; }
    .log-step .log-msg { color: #a78bfa; font-weight: 600; }

    .log-progress {
        height: 3px;
        background: #1e2030;
        position: relative;
        overflow: hidden;
    }
    .log-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #818cf8);
        transition: width .4s ease;
        width: 0%;
    }

    @keyframes pulse-dot {
        0%,100% { opacity:1; }
        50%      { opacity:.4; }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    @php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp

    {{-- ── HEADER ── --}}
    <div class="content-header">
        <div>
            <h2 style="color:var(--primary); font-size:28px; margin-bottom:4px;">Detail Transaksi</h2>
            <p style="color:var(--text-secondary);">
                No. Nota <strong>{{ $transaksi->no_nota }}</strong>
                &nbsp;·&nbsp;
                <span class="status-badge {{ $transaksi->status }}">
                    <i class="fas fa-{{ $transaksi->status === 'selesai' ? 'check-circle' : 'ban' }}"></i>
                    {{ strtoupper($transaksi->status) }}
                </span>
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button type="button" class="btn btn-primary" onclick="cetakQz()" id="btnCetak">
                <i class="fas fa-print"></i> Cetak Nota
            </button>
            @if ($transaksi->status === 'selesai' && auth()->user()->role === 'admin')
                <form action="{{ route($rp . '.transaksi.destroy', $transaksi->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban"></i> Batalkan
                    </button>
                </form>
            @endif
            <a href="{{ route($rp . '.transaksi.index') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- ── REAL-TIME PRINT LOG ── --}}
    <div id="printLogPanel">
        <div class="log-header">
            <div class="log-header-left">
                <div class="log-dot" id="logDot"></div>
                <span class="log-title">Print Log — QZ Tray</span>
            </div>
            <button class="log-close" onclick="closeLog()" title="Tutup log">×</button>
        </div>
        <div class="log-progress"><div class="log-progress-bar" id="logBar"></div></div>
        <div id="logBody"></div>
    </div>

    {{-- ── GRID INFO ATAS ── --}}
    <div class="detail-grid">
        <div class="info-card">
            <div class="info-card-header"><i class="fas fa-receipt"></i> Informasi Transaksi</div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-row-label">No. Transaksi</span>
                    <span class="info-row-value">{{ $transaksi->no_transaksi }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">No. Nota</span>
                    <span class="info-row-value"><strong>{{ $transaksi->no_nota }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Tanggal</span>
                    <span class="info-row-value">{{ $transaksi->dibuat_pada->translatedFormat('d F Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Status</span>
                    <span class="info-row-value">
                        <span class="status-badge {{ $transaksi->status }}">
                            <i class="fas fa-{{ $transaksi->status === 'selesai' ? 'check-circle' : 'ban' }}"></i>
                            {{ strtoupper($transaksi->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Metode Bayar</span>
                    <span class="info-row-value">
                        <span class="metode-badge">
                            <i class="fas fa-{{ $transaksi->metode_bayar === 'tunai' ? 'money-bill-wave' : 'credit-card' }}"></i>
                            {{ strtoupper($transaksi->metode_bayar) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="info-card-header"><i class="fas fa-users"></i> Kasir & Member</div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-row-label">Kasir</span>
                    <span class="info-row-value">
                        <i class="fas fa-user-tie" style="color:var(--primary);"></i>
                        {{ $transaksi->kasir->name }}
                    </span>
                </div>
                @if ($transaksi->member)
                    <div class="info-row">
                        <span class="info-row-label">Member</span>
                        <span class="info-row-value">
                            <i class="fas fa-id-card" style="color:#28a745;"></i>
                            {{ $transaksi->member->name }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Telepon</span>
                        <span class="info-row-value">{{ $transaksi->member->no_telepon ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Saldo Poin</span>
                        <span class="info-row-value" style="font-weight:700; color:var(--primary);">
                            {{ number_format($transaksi->member->saldo_poin ?? 0) }} poin
                        </span>
                    </div>
                @else
                    <div class="info-row">
                        <span class="info-row-label">Member</span>
                        <span class="info-row-value" style="color:var(--text-secondary);">
                            <i class="fas fa-user-slash"></i> Tanpa Member
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── TABEL PRODUK ── --}}
    <div class="info-card" style="margin-bottom:24px;">
        <div class="info-card-header">
            <i class="fas fa-box"></i> Daftar Produk
            <span style="margin-left:auto; font-size:13px; font-weight:400; color:var(--text-secondary);">
                {{ $transaksi->detail->count() }} item
            </span>
        </div>
        <div style="overflow-x:auto;">
            <table class="produk-table">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Produk</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Harga Satuan</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->detail as $i => $detail)
                        <tr>
                            <td style="color:var(--text-secondary); font-weight:600;">{{ $i + 1 }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $detail->produk->nama }}</div>
                                <div style="font-size:12px; color:var(--text-secondary); margin-top:2px;">
                                    {{ $detail->produk->kode_produk }}
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span style="font-weight:700;">{{ $detail->jumlah }}</span>
                                <span style="font-size:12px; color:var(--text-secondary);">{{ $detail->produk->satuan }}</span>
                            </td>
                            <td style="text-align:right;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td style="text-align:right; font-weight:700;">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── SUMMARY TOTAL ── --}}
    <div style="display:flex; justify-content:flex-end; margin-bottom:24px;">
        <div class="summary-box" style="min-width:360px;">
            <div class="summary-row">
                <span style="color:var(--text-secondary); font-weight:600;">Total Harga</span>
                <span style="font-weight:700;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span style="color:var(--text-secondary); font-weight:600;">Total Bayar</span>
                <span style="font-weight:700;">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
            @if ($transaksi->metode_bayar === 'tunai')
                <div class="summary-row">
                    <span style="color:var(--text-secondary); font-weight:600;">Kembalian</span>
                    <span style="font-weight:700; color:#28a745;">
                        Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                    </span>
                </div>
            @endif
            @if ($transaksi->riwayatPoin && $transaksi->riwayatPoin->jenis === 'masuk')
                <div class="summary-row poin-row">
                    <span style="font-weight:600; color:#92400e;">
                        <i class="fas fa-star" style="color:#f59e0b;"></i> Poin Didapat
                    </span>
                    <span style="font-weight:700; color:#92400e;">
                        +{{ number_format($transaksi->riwayatPoin->poin, 0, ',', '.') }} poin
                    </span>
                </div>
            @endif
            <div class="summary-row grand-total">
                <span>GRAND TOTAL</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- QZ Tray + crypto libs --}}
<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sha.js/2.4.11/sha.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsrsasign@10.5.25/lib/jsrsasign-all-min.js"></script>

<script>
/* ─────────────────────────────────────────────────────────────────
   CONFIG — sesuaikan jika perlu
   ─────────────────────────────────────────────────────────────── */
const PRINT_URL  = @json(route($rp . '.transaksi.print-qz', $transaksi->id));
const CSRF_TOKEN = @json(csrf_token());

/* ─────────────────────────────────────────────────────────────────
   LOG PANEL HELPERS
   ─────────────────────────────────────────────────────────────── */
let logStarted = false;

function openLog() {
    const panel = document.getElementById('printLogPanel');
    panel.classList.add('visible');
    if (!logStarted) {
        document.getElementById('logBody').innerHTML = '';
        logStarted = true;
    }
    // Scroll panel ke viewport
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function closeLog() {
    document.getElementById('printLogPanel').classList.remove('visible');
    logStarted = false;
}

function setProgress(pct) {
    document.getElementById('logBar').style.width = pct + '%';
}

function setDot(state) {
    // state: 'idle' | 'active' | 'error'
    const dot = document.getElementById('logDot');
    dot.className = 'log-dot' + (state !== 'idle' ? ' ' + state : '');
}

/**
 * Tambah baris log ke panel.
 * type: 'step' | 'ok' | 'err' | 'warn' | 'info' | 'dim'
 */
function log(msg, type = 'info') {
    const icons = {
        step: '▶', ok: '✔', err: '✘', warn: '⚠', info: '·', dim: ' '
    };
    const now = new Date().toLocaleTimeString('id-ID', { hour12: false });
    const body = document.getElementById('logBody');
    const line = document.createElement('div');
    line.className = `log-line log-${type}`;
    line.innerHTML =
        `<span class="log-time">${now}</span>` +
        `<span class="log-icon">${icons[type] ?? '·'}</span>` +
        `<span class="log-msg">${escHtml(msg)}</span>`;
    body.appendChild(line);
    body.scrollTop = body.scrollHeight;
}

function escHtml(s) {
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

/* ─────────────────────────────────────────────────────────────────
   QZ TRAY — skip sertifikat (development/LAN)
   Untuk production: isi setCertificatePromise & setSignaturePromise
   dengan private key yang benar.
   ─────────────────────────────────────────────────────────────── */
qz.security.setCertificatePromise(() => Promise.resolve(''));
qz.security.setSignatureAlgorithm('SHA512');
qz.security.setSignaturePromise(() => Promise.resolve(''));

/* ─────────────────────────────────────────────────────────────────
   FUNGSI UTAMA CETAK
   ─────────────────────────────────────────────────────────────── */
async function cetakQz() {
    const btn = document.getElementById('btnCetak');
    btn.disabled = true;

    // Buka log panel & reset
    document.getElementById('logBody').innerHTML = '';
    logStarted = true;
    openLog();
    setDot('active');
    setProgress(0);

    // ── STEP 1: Cek QZ Tray library ──────────────────────────────
    log('Memeriksa library QZ Tray...', 'step');

    if (typeof qz === 'undefined') {
        log('Library qz-tray.js tidak ditemukan di halaman!', 'err');
        log('Pastikan tag <script src="qz-tray.min.js"> sudah ada.', 'warn');
        finishLog(false, btn);
        return;
    }
    log('Library QZ Tray tersedia ✔', 'ok');
    setProgress(10);

    // ── STEP 2: Ambil ESC/POS Base64 dari server ─────────────────
    log('Menghubungi server untuk generate data ESC/POS...', 'step');
    let escposBase64, printerName;

    try {
        const res = await fetch(PRINT_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            }
        });

        log(`Server responded: HTTP ${res.status} ${res.statusText}`, res.ok ? 'dim' : 'warn');

        const payload = await res.json();
        log('Response JSON diterima ✔', 'dim');

        if (!payload.success) {
            log(`Server error: ${payload.message ?? 'Unknown error'}`, 'err');

            // Tampilkan detail jika ada (misal: stack trace dari Laravel)
            if (payload.exception) log(`Exception: ${payload.exception}`, 'err');
            if (payload.file)      log(`File: ${payload.file}:${payload.line}`, 'dim');

            finishLog(false, btn);
            return;
        }

        escposBase64 = payload.data;
        printerName  = payload.printer ?? 'POS58';

        const byteLen = Math.round(atob(escposBase64).length);
        log(`ESC/POS data OK — ${byteLen} bytes, printer target: "${printerName}"`, 'ok');
        setProgress(35);

    } catch (fetchErr) {
        log(`Gagal fetch ke server: ${fetchErr.message}`, 'err');
        if (fetchErr.message.includes('Failed to fetch')) {
            log('Kemungkinan CORS, server down, atau URL salah.', 'warn');
        }
        finishLog(false, btn);
        return;
    }

    // ── STEP 3: Koneksi ke QZ Tray ───────────────────────────────
    log('Mencoba koneksi ke QZ Tray (WebSocket ws://localhost:8181)...', 'step');

    try {
        if (qz.websocket.isActive()) {
            log('WebSocket sudah aktif, skip koneksi ulang.', 'dim');
        } else {
            // QZ Tray default: ws://localhost:8181 dan wss://localhost:8181
            await qz.websocket.connect({
                retries: 2,
                delay: 1,
            });
            log('WebSocket terhubung ke QZ Tray ✔', 'ok');
        }
        setProgress(55);

    } catch (wsErr) {
        log(`Gagal koneksi WebSocket: ${wsErr.message}`, 'err');

        if (wsErr.message.includes('Unable to establish') || wsErr.message.toLowerCase().includes('websocket')) {
            log('QZ Tray tidak berjalan di komputer ini!', 'warn');
            log('Cara mengatasi:', 'warn');
            log('  1. Download & install QZ Tray dari https://qz.io', 'dim');
            log('  2. Jalankan aplikasi QZ Tray (cek system tray/taskbar)', 'dim');
            log('  3. Izinkan koneksi dari browser jika ada popup QZ Tray', 'dim');
            log('  4. Pastikan tidak ada firewall yang blokir port 8181', 'dim');
        } else if (wsErr.message.includes('certificate') || wsErr.message.includes('ssl')) {
            log('SSL/Certificate error — coba akses halaman via HTTP (bukan HTTPS)', 'warn');
            log('Atau konfigurasi sertifikat QZ Tray untuk domain HTTPS Anda.', 'dim');
        } else {
            log(`Detail: ${wsErr.stack ?? wsErr}`, 'dim');
        }

        finishLog(false, btn);
        return;
    }

    // ── STEP 4: Cari printer ─────────────────────────────────────
    log(`Mencari printer dengan nama: "${printerName}"...`, 'step');
    let resolvedPrinter;

    try {
        const found = await qz.printers.find(printerName);
        resolvedPrinter = Array.isArray(found) ? found[0] : found;
        log(`Printer ditemukan: "${resolvedPrinter}" ✔`, 'ok');

    } catch (findErr) {
        log(`Printer "${printerName}" tidak ditemukan: ${findErr.message}`, 'warn');
        log('Mencari printer default...', 'dim');

        try {
            resolvedPrinter = await qz.printers.getDefault();
            log(`Menggunakan printer default: "${resolvedPrinter}"`, 'warn');
        } catch (defErr) {
            log(`Tidak ada printer default: ${defErr.message}`, 'err');
            log('Pastikan setidaknya satu printer terpasang dan di-share.', 'dim');
            finishLog(false, btn);
            return;
        }
    }

    setProgress(70);

    // ── STEP 5: Konfigurasi & kirim ke printer ───────────────────
    log(`Mengirim data ESC/POS ke printer "${resolvedPrinter}"...`, 'step');

    try {
        const config = qz.configs.create(resolvedPrinter, {
            rawCommandsOnly: true,
            encoding: 'RAW',
        });

        await qz.print(config, [{
            type: 'raw',
            format: 'base64',
            data: escposBase64,
        }]);

        setProgress(100);
        log(`Nota berhasil dikirim ke printer "${resolvedPrinter}" ✔`, 'ok');
        finishLog(true, btn);

    } catch (printErr) {
        log(`Gagal kirim ke printer: ${printErr.message}`, 'err');

        if (printErr.message.includes('denied') || printErr.message.includes('permission')) {
            log('Akses ke printer ditolak. Cek permission di pengaturan QZ Tray.', 'warn');
        } else if (printErr.message.includes('offline') || printErr.message.includes('not ready')) {
            log('Printer offline atau tidak siap. Cek koneksi USB/LAN printer.', 'warn');
        } else {
            log(`Stack: ${printErr.stack ?? printErr}`, 'dim');
        }

        finishLog(false, btn);
    }
}

function finishLog(success, btn) {
    btn.disabled = false;
    setDot(success ? 'idle' : 'error');

    if (success) {
        log('─── Selesai ───', 'dim');
        showToast('✔ Nota berhasil dicetak!', 'success');
    } else {
        log('─── Proses dihentikan karena error ───', 'dim');
        log('Scroll ke atas log untuk melihat detail error.', 'dim');
        showToast('✘ Cetak gagal — lihat log untuk detail', 'error');
    }
}

/* ─────────────────────────────────────────────────────────────────
   TOAST
   ─────────────────────────────────────────────────────────────── */
function showToast(msg, type = 'success') {
    const el = document.getElementById('toastNotif');
    if (el) el.remove();

    const toast = document.createElement('div');
    toast.id = 'toastNotif';
    toast.style.cssText = `
        position:fixed; bottom:24px; right:24px; z-index:99999;
        background:${type === 'success' ? '#065f46' : '#991b1b'};
        color:white; padding:16px 24px; border-radius:10px;
        font-size:15px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.3);
        max-width:400px; line-height:1.5;
    `;
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast?.remove(), 6000);
}

/* ─────────────────────────────────────────────────────────────────
   AUTO PRINT setelah transaksi baru berhasil disimpan
   ─────────────────────────────────────────────────────────────── */
@if (session('auto_print'))
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if (confirm('Cetak nota sekarang?')) cetakQz();
        }, 600);
    });
@endif
</script>

<style>
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush