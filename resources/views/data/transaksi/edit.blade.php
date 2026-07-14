@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('breadcrumb', 'Transaksi / Baru')
@section('page-title', 'Transaksi Baru')

@push('styles')
<style>
/* ===== POS LAYOUT ===== */
.pos-wrapper {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 20px;
    height: calc(100vh - 160px);
    min-height: 600px;
}

/* ===== PANEL KIRI: Produk ===== */
.pos-left {
    display: flex;
    flex-direction: column;
    gap: 14px;
    overflow: hidden;
}

.pos-search-bar {
    background: var(--bg-card);
    border-radius: 12px;
    padding: 14px 16px;
    border: 1px solid var(--border-color);
    display: flex;
    gap: 10px;
    align-items: center;
    flex-shrink: 0;
}

.pos-search-bar input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 15px;
    color: var(--text-main);
    outline: none;
}

.pos-search-bar input::placeholder {
    color: var(--text-secondary);
}

.pos-produk-grid {
    flex: 1;
    overflow-y: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
    padding-right: 4px;
    align-content: start;
}

.pos-produk-grid::-webkit-scrollbar {
    width: 4px;
}
.pos-produk-grid::-webkit-scrollbar-track { background: transparent; }
.pos-produk-grid::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }

.produk-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 14px;
    cursor: pointer;
    transition: all 0.18s ease;
    position: relative;
    overflow: hidden;
    user-select: none;
}

.produk-card:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.produk-card:active {
    transform: scale(0.97);
}

.produk-card.stok-habis {
    opacity: 0.45;
    cursor: not-allowed;
    pointer-events: none;
}

.produk-card-img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
    background: var(--bg-body);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: 28px;
}

.produk-card-nama {
    font-weight: 700;
    font-size: 13px;
    color: var(--text-main);
    margin-bottom: 4px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.produk-card-harga {
    font-size: 14px;
    font-weight: 700;
    color: var(--primary);
}

.produk-card-stok {
    font-size: 11px;
    color: var(--text-secondary);
    margin-top: 4px;
}

.stok-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: var(--danger);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
}

/* ===== PANEL KANAN: Keranjang ===== */
.pos-right {
    display: flex;
    flex-direction: column;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}

.pos-right-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}

.pos-right-header h3 {
    margin: 0;
    font-size: 16px;
    color: var(--text-main);
}

.pos-no-trx {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 2px;
    font-family: monospace;
}

/* Member Section */
.pos-member-section {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
    background: var(--bg-body);
}

.pos-member-info {
    display: none;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    margin-top: 8px;
}

.pos-member-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
}

/* Keranjang Items */
.pos-keranjang {
    flex: 1;
    overflow-y: auto;
    padding: 12px 16px;
}

.pos-keranjang::-webkit-scrollbar { width: 4px; }
.pos-keranjang::-webkit-scrollbar-track { background: transparent; }
.pos-keranjang::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }

.keranjang-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-color);
    animation: slideIn 0.2s ease;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(10px); }
    to { opacity: 1; transform: translateX(0); }
}

.keranjang-item:last-child { border-bottom: none; }

.keranjang-item-nama {
    flex: 1;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-main);
    line-height: 1.3;
}

.keranjang-item-harga {
    font-size: 12px;
    color: var(--text-secondary);
}

.keranjang-qty {
    display: flex;
    align-items: center;
    gap: 6px;
}

.qty-btn {
    width: 26px;
    height: 26px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background: var(--bg-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--text-main);
    transition: all 0.15s;
    font-weight: 700;
}

.qty-btn:hover { background: var(--primary); color: white; border-color: var(--primary); }
.qty-btn.minus:hover { background: var(--danger); border-color: var(--danger); }

.qty-num {
    width: 28px;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
}

.keranjang-subtotal {
    font-weight: 700;
    font-size: 13px;
    color: var(--success);
    min-width: 70px;
    text-align: right;
}

.keranjang-hapus {
    width: 24px;
    height: 24px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--danger);
    opacity: 0.5;
    transition: opacity 0.15s;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.keranjang-hapus:hover { opacity: 1; }

.keranjang-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: var(--text-secondary);
    gap: 12px;
    padding: 40px 0;
}

/* Footer Keranjang */
.pos-footer {
    border-top: 1px solid var(--border-color);
    padding: 16px;
    flex-shrink: 0;
}

.pos-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-size: 13px;
}

.pos-total-row.grand {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 14px;
    padding-top: 10px;
    border-top: 2px solid var(--border-color);
}

.pos-total-row.grand .amount {
    color: var(--primary);
    font-size: 20px;
}

.pos-bayar-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 12px;
}

.pos-poin-section {
    background: #fefce8;
    border: 1px solid #fde68a;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 12px;
    display: none;
}

.pos-kembalian {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 10px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.pos-kembalian-label { font-size: 13px; color: #166534; font-weight: 600; }
.pos-kembalian-amount { font-size: 20px; font-weight: 800; color: #16a34a; }

.btn-bayar {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    letter-spacing: 0.5px;
}

/* Metode Bayar Tabs */
.metode-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 12px;
}

.metode-tab {
    flex: 1;
    padding: 8px 6px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-body);
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    text-align: center;
    transition: all 0.15s;
}

.metode-tab.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Modal Barcode Scanner */
.scanner-modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.85);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.scanner-modal.active { display: flex; }

.scanner-modal-content {
    background: white;
    border-radius: 16px;
    padding: 24px;
    max-width: 550px;
    width: 90%;
}
</style>
@endpush

@section('content')
@php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp

@if(session('error'))
<div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; padding: 14px 18px; margin-bottom: 16px; color: #991b1b; display: flex; align-items: center; gap: 10px;">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<!-- POS Layout -->
<div class="pos-wrapper">

    <!-- ======== PANEL KIRI: Katalog Produk ======== -->
    <div class="pos-left">

        <!-- Search Bar -->
        <div class="pos-search-bar">
            <i class="fas fa-search" style="color: var(--text-secondary); font-size: 16px;"></i>
            <input type="text" id="produkSearch" placeholder="Cari nama atau kode produk...">
            <button type="button" id="btnScanProduk" class="btn btn-primary btn-sm" style="flex-shrink: 0;">
                <i class="fas fa-camera"></i> Scan
            </button>
        </div>

        <!-- Grid Produk -->
        <div class="pos-produk-grid" id="produkGrid">
            @forelse($produk as $p)
            <div class="produk-card {{ $p->stok <= 0 ? 'stok-habis' : '' }}"
                 data-id="{{ $p->id }}"
                 data-kode="{{ $p->kode_produk }}"
                 data-nama="{{ $p->nama }}"
                 data-harga="{{ $p->harga }}"
                 data-stok="{{ $p->stok }}"
                 data-satuan="{{ $p->satuan }}"
                 onclick="tambahKeKeranjang(this)">

                @if($p->stok <= $p->stok_minimum && $p->stok > 0)
                <div class="stok-badge">Menipis</div>
                @endif

                @if($p->foto)
                    <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama }}" class="produk-card-img" style="display: block;">
                @else
                    <div class="produk-card-img">
                        <i class="fas fa-box"></i>
                    </div>
                @endif

                <div class="produk-card-nama">{{ $p->nama }}</div>
                <div class="produk-card-harga">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                <div class="produk-card-stok">Stok: {{ $p->stok }} {{ $p->satuan }}</div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; color: var(--text-secondary); padding: 60px 0;">
                <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 12px; display: block;"></i>
                Tidak ada produk tersedia
            </div>
            @endforelse
        </div>
    </div>

    <!-- ======== PANEL KANAN: Keranjang ======== -->
    <div class="pos-right">
        <!-- Header -->
        <div class="pos-right-header">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3>🛒 Keranjang Belanja</h3>
                    <div class="pos-no-trx">{{ $noTransaksi }}</div>
                </div>
                <button type="button" onclick="kosongkanKeranjang()" class="btn btn-danger btn-sm" id="btnKosongkan" style="display:none;">
                    <i class="fas fa-trash"></i> Kosongkan
                </button>
            </div>
        </div>

        <!-- Member Section -->
        <div class="pos-member-section">
            <div style="display: flex; gap: 8px; align-items: center;">
                <input type="text" id="inputTeleponMember" class="form-control" placeholder="No. telepon member (opsional)..." style="flex:1; font-size:13px;">
                <button type="button" id="btnCariMember" class="btn btn-info btn-sm" style="flex-shrink:0; white-space:nowrap;">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>

            <div class="pos-member-info" id="memberInfo">
                <div class="pos-member-avatar" id="memberAvatar">?</div>
                <div style="flex:1;">
                    <div style="font-weight:700; font-size:13px;" id="memberNama">-</div>
                    <div style="font-size:11px; color:#3b82f6;" id="memberPoin">0 poin</div>
                </div>
                <button type="button" onclick="hapusMember()" style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:16px;">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>

        <!-- Keranjang Items -->
        <div class="pos-keranjang" id="keranjangList">
            <div class="keranjang-empty" id="keranjangEmpty">
                <i class="fas fa-shopping-basket" style="font-size: 40px; opacity: 0.3;"></i>
                <span style="font-size: 14px;">Pilih produk untuk ditambahkan</span>
            </div>
        </div>

        <!-- Footer: Total & Bayar -->
        <div class="pos-footer">
            <!-- Total -->
            <div class="pos-total-row grand">
                <span>Total</span>
                <span class="amount" id="displayTotal">Rp 0</span>
            </div>

            <!-- Metode Bayar -->
            <div class="metode-tabs">
                <div class="metode-tab active" data-metode="tunai" onclick="pilihMetode(this)">
                    <i class="fas fa-money-bill-wave"></i><br>Tunai
                </div>
                <div class="metode-tab" data-metode="transfer" onclick="pilihMetode(this)">
                    <i class="fas fa-university"></i><br>Transfer
                </div>
                <div class="metode-tab" data-metode="qris" onclick="pilihMetode(this)">
                    <i class="fas fa-qrcode"></i><br>QRIS
                </div>
            </div>

            <!-- Input Bayar (hanya tunai) -->
            <div class="pos-bayar-section" id="inputBayarSection">
                <div>
                    <label style="font-size:12px; color:var(--text-secondary); margin-bottom:4px; display:block;">Total Bayar</label>
                    <input type="number" id="inputTotalBayar" class="form-control" placeholder="0" style="font-size:14px; font-weight:600;" oninput="hitungKembalian()" min="0">
                </div>
                <div>
                    <!-- Quick amount buttons -->
                    <label style="font-size:12px; color:var(--text-secondary); margin-bottom:4px; display:block;">Uang Pas</label>
                    <button type="button" onclick="setUangPas()" class="btn btn-warning btn-sm" style="width:100%;">
                        <i class="fas fa-magic"></i> Uang Pas
                    </button>
                </div>
            </div>

            <!-- Kembalian -->
            <div class="pos-kembalian" id="kembalianDisplay" style="display:none;">
                <div class="pos-kembalian-label"><i class="fas fa-coins"></i> Kembalian</div>
                <div class="pos-kembalian-amount" id="displayKembalian">Rp 0</div>
            </div>

            <!-- Poin Section (hanya muncul jika ada member) -->
            <div class="pos-poin-section" id="poinSection">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    <span style="font-size:18px;">⭐</span>
                    <span style="font-size:13px; font-weight:700; color:#854d0e;">Poin yang akan diberikan</span>
                </div>
                <input type="number" id="inputPoinDiberikan" class="form-control" placeholder="0" min="0" style="font-size:14px;" oninput="updatePoinDisplay()">
                <div style="font-size:11px; color:#a16207; margin-top:6px;" id="poinInfo">Masukkan jumlah poin untuk member ini</div>
            </div>

            <!-- Tombol Bayar -->
            <button type="button" class="btn btn-primary btn-bayar" id="btnBayar" onclick="prosesTransaksi()" disabled>
                <i class="fas fa-cash-register"></i> Proses Pembayaran
            </button>
        </div>
    </div>
</div>

<!-- ======== Modal Barcode Scanner ======== -->
<div class="scanner-modal" id="scannerModal">
    <div class="scanner-modal-content">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="margin:0; color:var(--primary);">
                <i class="fas fa-barcode"></i> Scan Barcode Produk
            </h3>
            <button type="button" onclick="tutupScanner()" style="background:none;border:none;font-size:24px;cursor:pointer;color:var(--text-secondary);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="scannerReader" style="border-radius:8px; overflow:hidden;"></div>
        <div id="scannerResult" style="margin-top:12px; padding:10px; background:#d1fae5; border-radius:8px; display:none; color:#065f46; font-weight:600;">
            <i class="fas fa-check-circle"></i> <span id="scannerResultText"></span>
        </div>
        <p style="margin-top:12px; font-size:12px; color:var(--text-secondary); text-align:center;">
            <i class="fas fa-info-circle"></i> Arahkan kamera ke barcode produk
        </p>
    </div>
</div>

<!-- Form Submit (hidden) -->
<form id="formTransaksi" action="{{ route($rp.'.transaksi.store') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="no_transaksi" value="{{ $noTransaksi }}">
    <input type="hidden" name="total_harga" id="fTotalHarga">
    <input type="hidden" name="total_bayar" id="fTotalBayar">
    <input type="hidden" name="kembalian" id="fKembalian">
    <input type="hidden" name="metode_bayar" id="fMetodeBayar" value="tunai">
    <input type="hidden" name="id_member" id="fIdMember">
    <input type="hidden" name="poin_diberikan" id="fPoinDiberikan">
    <div id="fItems"></div>
</form>

@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
// ===========================
// STATE
// ===========================
let keranjang = [];
let selectedMember = null;
let selectedMetode = 'tunai';
let scanner = null;

// ===========================
// FORMAT RUPIAH
// ===========================
function rupiah(angka) {
    return 'Rp ' + parseInt(angka || 0).toLocaleString('id-ID');
}

// ===========================
// TAMBAH KE KERANJANG
// ===========================
function tambahKeKeranjang(el) {
    const id     = parseInt(el.dataset.id);
    const kode   = el.dataset.kode;
    const nama   = el.dataset.nama;
    const harga  = parseFloat(el.dataset.harga);
    const stok   = parseInt(el.dataset.stok);
    const satuan = el.dataset.satuan;

    const existing = keranjang.find(i => i.id === id);

    if (existing) {
        if (existing.jumlah >= stok) {
            showToast('Stok tidak mencukupi!', 'error');
            return;
        }
        existing.jumlah++;
        existing.subtotal = existing.jumlah * harga;
    } else {
        keranjang.push({ id, kode, nama, harga, stok, satuan, jumlah: 1, subtotal: harga });
    }

    renderKeranjang();
    showToast(nama + ' ditambahkan ✓', 'success');
}

// ===========================
// RENDER KERANJANG
// ===========================
function renderKeranjang() {
    const list   = document.getElementById('keranjangList');
    const empty  = document.getElementById('keranjangEmpty');
    const btnKos = document.getElementById('btnKosongkan');

    if (keranjang.length === 0) {
        list.innerHTML = '';
        list.appendChild(empty);
        empty.style.display = 'flex';
        btnKos.style.display = 'none';
        updateTotal();
        return;
    }

    empty.style.display = 'none';
    btnKos.style.display = 'block';

    list.innerHTML = keranjang.map((item, idx) => `
        <div class="keranjang-item">
            <div style="flex:1; min-width:0;">
                <div class="keranjang-item-nama">${item.nama}</div>
                <div class="keranjang-item-harga">${rupiah(item.harga)} / ${item.satuan}</div>
            </div>
            <div class="keranjang-qty">
                <button class="qty-btn minus" onclick="ubahQty(${idx}, -1)">−</button>
                <span class="qty-num">${item.jumlah}</span>
                <button class="qty-btn" onclick="ubahQty(${idx}, 1)">+</button>
            </div>
            <div class="keranjang-subtotal">${rupiah(item.subtotal)}</div>
            <button class="keranjang-hapus" onclick="hapusItem(${idx})">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');

    updateTotal();
}

// ===========================
// UBAH QTY
// ===========================
function ubahQty(idx, delta) {
    const item = keranjang[idx];
    const newQty = item.jumlah + delta;

    if (newQty <= 0) {
        hapusItem(idx);
        return;
    }
    if (newQty > item.stok) {
        showToast('Stok tidak mencukupi!', 'error');
        return;
    }

    item.jumlah = newQty;
    item.subtotal = newQty * item.harga;
    renderKeranjang();
}

// ===========================
// HAPUS ITEM
// ===========================
function hapusItem(idx) {
    keranjang.splice(idx, 1);
    renderKeranjang();
}

// ===========================
// KOSONGKAN KERANJANG
// ===========================
function kosongkanKeranjang() {
    if (!confirm('Kosongkan semua item keranjang?')) return;
    keranjang = [];
    renderKeranjang();
}

// ===========================
// UPDATE TOTAL
// ===========================
function updateTotal() {
    const total = keranjang.reduce((sum, i) => sum + i.subtotal, 0);
    document.getElementById('displayTotal').textContent = rupiah(total);
    document.getElementById('fTotalHarga').value = total;

    // Update btn bayar
    const btnBayar  = document.getElementById('btnBayar');
    const totalBayar = parseFloat(document.getElementById('inputTotalBayar').value) || 0;

    if (selectedMetode === 'tunai') {
        btnBayar.disabled = (keranjang.length === 0 || totalBayar < total);
    } else {
        btnBayar.disabled = keranjang.length === 0;
    }

    hitungKembalian();
}

// ===========================
// HITUNG KEMBALIAN
// ===========================
function hitungKembalian() {
    const total      = keranjang.reduce((sum, i) => sum + i.subtotal, 0);
    const totalBayar = parseFloat(document.getElementById('inputTotalBayar').value) || 0;
    const kembalian  = totalBayar - total;

    const kembalianDisplay = document.getElementById('kembalianDisplay');
    const displayKembalian = document.getElementById('displayKembalian');
    const btnBayar         = document.getElementById('btnBayar');

    if (totalBayar > 0) {
        kembalianDisplay.style.display = 'flex';
        displayKembalian.textContent   = rupiah(Math.max(0, kembalian));
        displayKembalian.style.color   = kembalian >= 0 ? '#16a34a' : '#dc2626';
    } else {
        kembalianDisplay.style.display = 'none';
    }

    document.getElementById('fTotalBayar').value = totalBayar;
    document.getElementById('fKembalian').value  = Math.max(0, kembalian);

    if (selectedMetode === 'tunai') {
        btnBayar.disabled = (keranjang.length === 0 || kembalian < 0 || totalBayar <= 0);
    }
}

// ===========================
// UANG PAS
// ===========================
function setUangPas() {
    const total = keranjang.reduce((sum, i) => sum + i.subtotal, 0);
    document.getElementById('inputTotalBayar').value = total;
    hitungKembalian();
}

// ===========================
// PILIH METODE BAYAR
// ===========================
function pilihMetode(el) {
    document.querySelectorAll('.metode-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    selectedMetode = el.dataset.metode;
    document.getElementById('fMetodeBayar').value = selectedMetode;

    const inputBayarSection = document.getElementById('inputBayarSection');
    const kembalianDisplay  = document.getElementById('kembalianDisplay');

    if (selectedMetode === 'tunai') {
        inputBayarSection.style.display = 'grid';
    } else {
        inputBayarSection.style.display = 'none';
        kembalianDisplay.style.display  = 'none';
        // Set total bayar = total harga untuk non tunai
        const total = keranjang.reduce((sum, i) => sum + i.subtotal, 0);
        document.getElementById('fTotalBayar').value = total;
        document.getElementById('fKembalian').value  = 0;
    }

    updateTotal();
}

// ===========================
// CARI MEMBER
// ===========================
document.getElementById('btnCariMember').addEventListener('click', async function () {
    const telepon = document.getElementById('inputTeleponMember').value.trim();
    if (!telepon) { showToast('Masukkan nomor telepon member', 'error'); return; }

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const res  = await fetch(`{{ route($rp.'.transaksi.cari-member') }}?no_telepon=${telepon}`);
        const data = await res.json();

        if (data.success) {
            selectedMember = data.member;
            document.getElementById('memberAvatar').textContent = data.member.name.charAt(0).toUpperCase();
            document.getElementById('memberNama').textContent   = data.member.name;
            document.getElementById('memberPoin').textContent   = number_format(data.member.saldo_poin) + ' poin';
            document.getElementById('memberInfo').style.display  = 'flex';
            document.getElementById('fIdMember').value          = data.member.id;
            document.getElementById('poinSection').style.display = 'block';
            showToast('Member ' + data.member.name + ' ditemukan ✓', 'success');
        } else {
            showToast(data.message, 'error');
            hapusMember();
        }
    } catch (e) {
        showToast('Gagal menghubungi server', 'error');
    }

    this.disabled = false;
    this.innerHTML = '<i class="fas fa-search"></i> Cari';
});

function hapusMember() {
    selectedMember = null;
    document.getElementById('memberInfo').style.display  = 'none';
    document.getElementById('poinSection').style.display = 'none';
    document.getElementById('fIdMember').value           = '';
    document.getElementById('fPoinDiberikan').value      = '';
    document.getElementById('inputTeleponMember').value  = '';
    document.getElementById('inputPoinDiberikan').value  = '';
}

function updatePoinDisplay() {
    const poin = parseInt(document.getElementById('inputPoinDiberikan').value) || 0;
    document.getElementById('fPoinDiberikan').value = poin;
    if (selectedMember) {
        document.getElementById('poinInfo').textContent =
            'Saldo poin setelah transaksi: ' + number_format(selectedMember.saldo_poin + poin);
    }
}

function number_format(n) {
    return parseInt(n || 0).toLocaleString('id-ID');
}

// ===========================
// PROSES TRANSAKSI
// ===========================
function prosesTransaksi() {
    if (keranjang.length === 0) {
        showToast('Keranjang masih kosong!', 'error'); return;
    }

    const total      = keranjang.reduce((sum, i) => sum + i.subtotal, 0);
    const totalBayar = selectedMetode === 'tunai'
        ? parseFloat(document.getElementById('inputTotalBayar').value) || 0
        : total;

    if (selectedMetode === 'tunai' && totalBayar < total) {
        showToast('Total bayar kurang!', 'error'); return;
    }

    // Build items input
    const fItems = document.getElementById('fItems');
    fItems.innerHTML = '';
    keranjang.forEach((item, idx) => {
        fItems.innerHTML += `
            <input type="hidden" name="items[${idx}][id_produk]"    value="${item.id}">
            <input type="hidden" name="items[${idx}][jumlah]"       value="${item.jumlah}">
            <input type="hidden" name="items[${idx}][harga_satuan]" value="${item.harga}">
            <input type="hidden" name="items[${idx}][subtotal]"     value="${item.subtotal}">
        `;
    });

    document.getElementById('fTotalHarga').value  = total;
    document.getElementById('fTotalBayar').value  = totalBayar;
    document.getElementById('fKembalian').value   = Math.max(0, totalBayar - total);
    document.getElementById('fMetodeBayar').value = selectedMetode;

    const poin = parseInt(document.getElementById('inputPoinDiberikan').value) || 0;
    document.getElementById('fPoinDiberikan').value = poin;

    if (!confirm(`Proses transaksi sebesar ${rupiah(total)}?`)) return;

    document.getElementById('btnBayar').disabled = true;
    document.getElementById('btnBayar').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    document.getElementById('formTransaksi').submit();
}

// ===========================
// SEARCH PRODUK
// ===========================
document.getElementById('produkSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.produk-card').forEach(card => {
        const nama = card.dataset.nama.toLowerCase();
        const kode = card.dataset.kode.toLowerCase();
        card.style.display = (nama.includes(q) || kode.includes(q)) ? '' : 'none';
    });
});

// ===========================
// BARCODE SCANNER
// ===========================
document.getElementById('btnScanProduk').addEventListener('click', function () {
    document.getElementById('scannerModal').classList.add('active');
    bukaScanner();
});

function tutupScanner() {
    document.getElementById('scannerModal').classList.remove('active');
    if (scanner) {
        scanner.stop().then(() => { scanner.clear(); scanner = null; }).catch(() => {});
    }
}

function bukaScanner() {
    scanner = new Html5Qrcode("scannerReader");
    scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 300, height: 150 }, aspectRatio: 1.777778 },
        async (decodedText) => {
            document.getElementById('scannerResultText').textContent = 'Mencari: ' + decodedText;
            document.getElementById('scannerResult').style.display = 'block';

            scanner.stop().then(() => { scanner.clear(); scanner = null; }).catch(() => {});

            // Cari produk via AJAX
            try {
                const res  = await fetch(`{{ route($rp.'.transaksi.cari-produk') }}?kode=${decodedText}`);
                const data = await res.json();

                if (data.success) {
                    // Buat elemen sementara untuk tambahKeKeranjang
                    const el = document.createElement('div');
                    el.dataset.id     = data.produk.id;
                    el.dataset.kode   = data.produk.kode_produk;
                    el.dataset.nama   = data.produk.nama;
                    el.dataset.harga  = data.produk.harga;
                    el.dataset.stok   = data.produk.stok;
                    el.dataset.satuan = data.produk.satuan;
                    tambahKeKeranjang(el);
                    showToast(data.produk.nama + ' ditambahkan ✓', 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (e) {
                showToast('Gagal mencari produk', 'error');
            }

            setTimeout(() => {
                document.getElementById('scannerModal').classList.remove('active');
                document.getElementById('scannerResult').style.display = 'none';
            }, 1500);
        },
        () => {}
    ).catch(() => {
        alert('Tidak dapat mengakses kamera.');
    });
}

document.getElementById('scannerModal').addEventListener('click', function (e) {
    if (e.target === this) tutupScanner();
});

// ===========================
// TOAST NOTIFICATION
// ===========================
function showToast(msg, type = 'success') {
    const existing = document.getElementById('posToast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'posToast';
    toast.style.cssText = `
        position: fixed; bottom: 24px; right: 24px; z-index: 99999;
        background: ${type === 'success' ? '#065f46' : '#991b1b'};
        color: white; padding: 12px 20px; border-radius: 10px;
        font-size: 14px; font-weight: 600; box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        animation: toastIn 0.3s ease; max-width: 300px;
    `;
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle" style="margin-right:8px;"></i>${msg}`;

    const style = document.createElement('style');
    style.textContent = '@keyframes toastIn { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }';
    document.head.appendChild(style);

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}

// Init
renderKeranjang();
</script>
@endpush