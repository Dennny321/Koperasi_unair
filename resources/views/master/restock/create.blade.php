@extends('layouts.app')

@section('title', 'Tambah Restock')
@section('breadcrumb', 'Master / Restock / Tambah')
@section('page-title', 'Tambah Restock')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            color: var(--text-main);
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb, 13, 110, 253), 0.15);
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 13px;
        }

        .select2-results__option--highlighted {
            background-color: var(--primary) !important;
        }

        .select2-results__option {
            padding: 6px 10px;
        }

        .stok-badge {
            font-size: 11px;
            padding: 1px 7px;
            border-radius: 4px;
            font-weight: 600;
        }

        .stok-ok {
            background: #dcfce7;
            color: #166534;
        }

        .stok-low {
            background: #fef9c3;
            color: #854d0e;
        }

        .stok-nil {
            background: #fee2e2;
            color: #991b1b;
        }

        .scanner-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .scanner-modal.active {
            display: flex;
        }

        .scanner-modal-content {
            background: white;
            border-radius: 16px;
            padding: 24px;
            max-width: 520px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .scanner-result {
            margin-top: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            display: none;
            font-weight: 600;
            font-size: 14px;
            transition: all .2s;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah Restock Baru</h2>
            <p style="color: var(--text-secondary);">Lengkapi formulir di bawah untuk menambah restock</p>
        </div>
        <a href="{{ route('admin.restock.index') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.restock.store') }}" method="POST" id="restockForm">
        @csrf

        <!-- Card Informasi Restock -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Restock</h3>
            </div>

            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <div class="form-group">
                        <label class="form-label required">Kode Restock</label>
                        <input type="text" name="kode_restock"
                            class="form-control @error('kode_restock') is-invalid @enderror"
                            value="{{ old('kode_restock', $kodeRestock) }}" readonly required>
                        @error('kode_restock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tanggal Restock</label>
                        <input type="date" name="tanggal_restock"
                            class="form-control @error('tanggal_restock') is-invalid @enderror"
                            value="{{ old('tanggal_restock', date('Y-m-d')) }}" required>
                        @error('tanggal_restock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Supplier</label>
                        <select name="id_supplier" class="form-control @error('id_supplier') is-invalid @enderror">
                            <option value="">Pilih Supplier (Opsional)</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('id_supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_supplier')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="2"
                        placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai (Langsung Update
                            Stok)</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small style="color: var(--text-secondary);">Jika status "Selesai", stok produk akan langsung
                        bertambah.</small>
                </div>
            </div>
        </div>

        <!-- Card Daftar Produk -->
        <div class="card" style="margin-top: 24px;">
            <div class="card-header">
                <h3 class="card-title">Daftar Produk</h3>
                <div style="display:flex; gap:8px;">
                    {{-- <button type="button" class="btn btn-outline-primary btn-sm" id="btnScanBarcode">
                        <i class="fas fa-barcode"></i> Scan
                    </button> --}}
                    <button type="button" class="btn btn-primary btn-sm" onclick="tambahProduk()">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                </div>
            </div>

            <div style="padding: 24px;">
                <div id="produkContainer">
                    <!-- Produk items akan ditambahkan di sini -->
                </div>

                @error('produk')
                    <div class="alert alert-danger" style="margin-top: 16px;">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Total Biaya -->
                <div
                    style="margin-top: 24px; padding: 20px; background: var(--bg-body); border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; color: var(--text-main);">Total Biaya:</h3>
                    <h2 style="margin: 0; color: var(--success); font-size: 28px; font-weight: 800;" id="totalBiaya">Rp 0
                    </h2>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i>
                Simpan Restock
            </button>
            <a href="{{ route('admin.restock.index') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-times"></i>
                Batal
            </a>
        </div>
    </form>

    <!-- Template Produk Item -->
    <template id="produkItemTemplate">
        <div class="produk-item"
            style="border: 2px solid var(--border-color); border-radius: 10px; padding: 20px; margin-bottom: 16px; position: relative;">
            <button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(this)"
                style="position: absolute; top: 16px; right: 16px;">
                <i class="fas fa-trash"></i>
            </button>

            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 2fr; gap: 16px; align-items: start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label required">Produk</label>
                    <select name="produk[INDEX][id_produk]" class="form-control produk-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" data-kode="{{ $produk->kode_produk }}"
                                data-stok="{{ $produk->stok ?? 0 }}" data-harga="{{ $produk->harga }}"
                                data-satuan="{{ $produk->satuan }}">
                                {{ $produk->nama }} ({{ $produk->kategori->nama ?? 'No Category' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label required">Jumlah</label>
                    <input type="number" name="produk[INDEX][jumlah]" class="form-control jumlah-input" placeholder="0"
                        min="1" required onchange="hitungSubtotal(this)">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label required">Harga Beli</label>
                    <input type="number" name="produk[INDEX][harga_beli]" class="form-control harga-input"
                        placeholder="0" step="0.01" min="0" required onchange="hitungSubtotal(this)">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="produk[INDEX][catatan]" class="form-control"
                        placeholder="Catatan produk...">
                </div>
            </div>

            <div class="produk-info"
                style="margin-top: 12px; padding: 12px; background: var(--bg-body); border-radius: 8px; display: none;">
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <div>
                        <strong>Kode:</strong> <span class="info-kode">-</span> |
                        <strong>Stok Saat Ini:</strong> <span class="info-stok">-</span> <span class="info-satuan"></span>
                    </div>
                    <div>
                        <strong>Subtotal:</strong> <span class="info-subtotal"
                            style="color: var(--success); font-weight: 700; font-size: 15px;">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Scanner Kamera -->
    <div class="scanner-modal" id="scannerModal">
        <div class="scanner-modal-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div>
                    <h5 style="margin:0;color:var(--primary);font-weight:800;">
                        <i class="fas fa-barcode me-2"></i>Scan Barcode Produk
                    </h5>
                    <p style="font-size:12px;color:var(--text-secondary);margin-top:4px;margin-bottom:0;">
                        Scanner tetap aktif — scan berulang kali untuk banyak produk
                    </p>
                </div>
                <button type="button" onclick="tutupScanner()"
                    style="background:none;border:none;font-size:22px;cursor:pointer;color:var(--text-secondary);">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="scannerReader" style="border-radius:8px;overflow:hidden;"></div>

            <div class="scanner-result" id="scannerResult"></div>

            <div style="margin-top:14px;display:flex;justify-content:space-between;align-items:center;">
                <p style="font-size:11px;color:var(--text-secondary);margin:0;">
                    <i class="fas fa-info-circle"></i> Arahkan kamera ke barcode produk
                </p>
                <button type="button" onclick="tutupScanner()" class="btn btn-warning btn-sm">
                    <i class="fas fa-check me-1"></i> Selesai Scan
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        let produkIndex = 0;
        let scanner = null;
        let scannerBusy = false;

        const produkMap = {};
        @foreach ($produks as $produk)
        produkMap['{{ strtolower($produk->kode_produk) }}'] = {
            id: {{ $produk->id }},
            harga: {{ $produk->harga ?? 0 }},
            satuan: '{{ addslashes($produk->satuan) }}',
            stok: {{ $produk->stok ?? 0 }},
            kode: '{{ addslashes($produk->kode_produk) }}',
            nama: '{{ addslashes($produk->nama) }}',
            text: '{{ addslashes($produk->nama) }} ({{ addslashes($produk->kategori->nama ?? "No Category") }})',
        };
        @endforeach

        /* ═══════════════ TAMBAH / HAPUS PRODUK ═══════════════ */
        function tambahProduk() {
            const template = document.getElementById('produkItemTemplate');
            const clone = template.content.cloneNode(true);
            const html = clone.querySelector('.produk-item').outerHTML.replace(/INDEX/g, produkIndex);

            document.getElementById('produkContainer').insertAdjacentHTML('beforeend', html);

            const items = document.querySelectorAll('.produk-item');
            const item = items[items.length - 1];
            initSelect2(item);

            produkIndex++;
            return item;
        }

        function hapusProduk(btn) {
            const item = btn.closest('.produk-item');
            $(item.querySelector('.produk-select')).select2('destroy');
            item.remove();
            hitungTotalBiaya();
        }

        /* ═══════════════ SELECT2 ═══════════════ */
        function initSelect2(item) {
            const select = item.querySelector('.produk-select');
            $(select).select2({
                placeholder: 'Cari / Pilih Produk',
                allowClear: true,
                width: '100%',
                matcher: matcherProduk,
                language: {
                    noResults: () => 'Produk tidak ditemukan',
                    searching: () => 'Mencari...',
                },
                templateResult: formatProdukOption,
                templateSelection: formatProdukSelected,
                dropdownParent: $(item),
            });

            $(select).on('select2:select select2:clear', function() {
                updateProdukInfo(this);
            });
        }

        function matcherProduk(params, data) {
            if ($.trim(params.term) === '') return data;
            if (typeof data.element === 'undefined') return null;
            const term = params.term.toLowerCase();
            const teks = (data.text || '').toLowerCase();
            const kode = (data.element.dataset.kode || '').toLowerCase();
            if (teks.indexOf(term) > -1 || kode.indexOf(term) > -1) return data;
            return null;
        }

        function formatProdukOption(option) {
            if (!option.id) return option.text;
            const el = option.element;
            const stok = parseInt(el.dataset.stok || 0);
            const sat = el.dataset.satuan ?? '';
            const cls = stok > 5 ? 'stok-ok' : stok > 0 ? 'stok-low' : 'stok-nil';
            return $(`<span style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                       <span>${option.text}</span>
                       <span class="stok-badge ${cls}">Stok: ${stok} ${sat}</span>
                     </span>`);
        }

        function formatProdukSelected(option) {
            return option.text || option.id;
        }

        /* ═══════════════ INFO & SUBTOTAL ═══════════════ */
        function updateProdukInfo(select) {
            const item = select.closest('.produk-item');
            const option = select.options[select.selectedIndex];

            if (select.value) {
                item.querySelector('.info-kode').textContent   = option.dataset.kode;
                item.querySelector('.info-stok').textContent   = option.dataset.stok;
                item.querySelector('.info-satuan').textContent = option.dataset.satuan;
                item.querySelector('.harga-input').value       = option.dataset.harga;
                item.querySelector('.produk-info').style.display = 'block';
                hitungSubtotal(select);
            } else {
                item.querySelector('.produk-info').style.display = 'none';
            }
        }

        function hitungSubtotal(element) {
            const item = element.closest('.produk-item');
            const jumlah   = parseFloat(item.querySelector('.jumlah-input').value) || 0;
            const harga    = parseFloat(item.querySelector('.harga-input').value)  || 0;
            item.querySelector('.info-subtotal').textContent = formatRupiah(jumlah * harga);
            hitungTotalBiaya();
        }

        function hitungTotalBiaya() {
            let total = 0;
            document.querySelectorAll('.produk-item').forEach(item => {
                const jumlah = parseFloat(item.querySelector('.jumlah-input').value) || 0;
                const harga  = parseFloat(item.querySelector('.harga-input').value)  || 0;
                total += jumlah * harga;
            });
            document.getElementById('totalBiaya').textContent = formatRupiah(total);
        }

        function formatRupiah(angka) {
            return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        /* ═══════════════ PILIH PRODUK DARI BARCODE ═══════════════ */
        function pilihProdukDariBarcode(kodeBarcode) {
            const key    = kodeBarcode.trim().toLowerCase();
            const produk = produkMap[key];

            if (!produk) {
                showToast('❌ Produk "' + kodeBarcode + '" tidak ditemukan', 'error');
                return false;
            }

            // Jika produk sudah ada di daftar → tambah jumlah saja
            const itemAda = [...document.querySelectorAll('.produk-item')].find(item => {
                const sel = item.querySelector('.produk-select');
                return sel && sel.value == produk.id;
            });

            if (itemAda) {
                const jumlahInput = itemAda.querySelector('.jumlah-input');
                jumlahInput.value = (parseInt(jumlahInput.value) || 0) + 1;
                hitungSubtotal(jumlahInput);
                showToast('✅ ' + produk.nama + ' ×' + jumlahInput.value, 'success');
                return true;
            }

            // Produk belum ada — tambah baris baru
            const item   = tambahProduk();
            const select = item.querySelector('.produk-select');

            // Buat option baru dengan data-* lengkap lalu set ke Select2
            const opt           = new Option(produk.text, produk.id, true, true);
            opt.dataset.kode    = produk.kode;
            opt.dataset.stok    = produk.stok;
            opt.dataset.harga   = produk.harga;
            opt.dataset.satuan  = produk.satuan;

            // Hapus option kosong default, sisipkan option produk
            $(select).empty().append(opt).val(produk.id).trigger('change');

            // ✅ FIX: panggil updateProdukInfo langsung via native select
            // setelah Select2 selesai memproses trigger('change')
            setTimeout(() => {
                updateProdukInfo(select);
                item.querySelector('.jumlah-input').value = 1;
                hitungSubtotal(item.querySelector('.jumlah-input'));
            }, 50);

            showToast('✅ ' + produk.nama + ' ditambahkan', 'success');
            return true;
        }

        /* ═══════════════ SCANNER KAMERA ═══════════════ */
        // Hanya pasang listener jika tombol scan kamera tersedia di DOM
        const btnScan = document.getElementById('btnScanBarcode');
        if (btnScan) {
            btnScan.addEventListener('click', function () {
                document.getElementById('scannerModal').classList.add('active');
                bukaScanner();
            });
        }

        function bukaScanner() {
            if (scanner) return;
            scanner = new Html5Qrcode('scannerReader');
            scanner.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 280, height: 120 }, aspectRatio: 1.777778 },
                function (decodedText) {
                    if (scannerBusy) return;
                    scannerBusy = true;
                    tampilkanHasilScanner('⏳ Mencari: ' + decodedText, '#fef3c7', '#92400e');
                    const ok = pilihProdukDariBarcode(decodedText);
                    tampilkanHasilScanner(
                        ok ? '✅ Produk ditemukan & ditambahkan!' : '❌ Produk tidak ditemukan: ' + decodedText,
                        ok ? '#d1fae5' : '#fee2e2',
                        ok ? '#065f46' : '#991b1b'
                    );
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const o = ctx.createOscillator();
                        o.connect(ctx.destination);
                        o.frequency.value = 880;
                        o.start(); o.stop(ctx.currentTime + 0.08);
                    } catch (e) {}
                    setTimeout(() => { scannerBusy = false; document.getElementById('scannerResult').style.display = 'none'; }, 1500);
                },
                function () {}
            ).catch(function () {
                showToast('Tidak dapat mengakses kamera.', 'error');
                tutupScanner();
            });
        }

        function tutupScanner() {
            document.getElementById('scannerModal').classList.remove('active');
            if (scanner) {
                scanner.stop().then(() => { scanner.clear(); scanner = null; }).catch(() => {});
            }
            scannerBusy = false;
        }

        function tampilkanHasilScanner(pesan, bg, clr) {
            const el = document.getElementById('scannerResult');
            el.innerHTML = pesan; el.style.background = bg; el.style.color = clr; el.style.display = 'block';
        }

        document.getElementById('scannerModal').addEventListener('click', function (e) {
            if (e.target === this) tutupScanner();
        });

        /* ═══════════════ SCANNER USB / BLUETOOTH ═══════════════ */
        (function () {
            let buffer = '';
            let timer  = null;

            document.addEventListener('keydown', function (e) {
                const tag = document.activeElement.tagName;
                if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return;
                if (document.getElementById('scannerModal').classList.contains('active')) return;

                if (e.key === 'Enter') {
                    if (buffer.length >= 3) pilihProdukDariBarcode(buffer.trim());
                    buffer = '';
                    if (timer) clearTimeout(timer);
                    return;
                }

                if (e.key.length === 1) {
                    buffer += e.key;
                    if (timer) clearTimeout(timer);
                    timer = setTimeout(() => { buffer = ''; }, 200);
                }
            });
        })();

        /* ═══════════════ TOAST ═══════════════ */
        function showToast(msg, type = 'success') {
            const old = document.getElementById('restockToast');
            if (old) old.remove();
            const toast = document.createElement('div');
            toast.id = 'restockToast';
            toast.style.cssText = `
                position:fixed; bottom:24px; right:24px; z-index:99999;
                background:${type === 'success' ? '#065f46' : '#991b1b'};
                color:white; padding:12px 20px; border-radius:10px;
                font-size:14px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,0.2);
                animation:toastIn 0.3s ease; max-width:320px;
            `;
            toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${msg}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }

        /* ═══════════════ VALIDASI & INIT ═══════════════ */
        document.getElementById('restockForm').addEventListener('submit', function (e) {
            if (document.querySelectorAll('.produk-item').length === 0) {
                e.preventDefault();
                alert('Tambahkan minimal 1 produk!');
            }
        });

        window.addEventListener('load', function () {
            tambahProduk();
        });
    </script>
@endpush