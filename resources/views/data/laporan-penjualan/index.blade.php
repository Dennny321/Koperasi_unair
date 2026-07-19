@extends('layouts.app')

@section('title', 'Laporan Penjualan - Koperasi UNAIR')
@section('breadcrumb', 'Pages / Admin / Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3730a3 0%, #4f46e5 100%);
        --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    }

    /* SUMMARY CARDS - Redesign Modern */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .summary-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #e2e8f0;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-gradient);
    }

    .summary-card.card-transactions::before { background: var(--primary-gradient); }
    .summary-card.card-revenue::before { background: var(--success-gradient); }
    .summary-card.card-average::before { background: var(--info-gradient); }

    .summary-content {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .summary-info h3 {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .summary-info .value {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .summary-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--icon-bg);
        flex-shrink: 0;
    }

    .summary-icon-wrap i {
        font-size: 24px;
        color: var(--icon-color);
    }

    .card-transactions .summary-icon-wrap { background: rgba(79, 70, 229, 0.1); }
    .card-transactions .summary-icon-wrap i { color: #4f46e5; }

    .card-revenue .summary-icon-wrap { background: rgba(16, 185, 129, 0.1); }
    .card-revenue .summary-icon-wrap i { color: #10b981; }

    .card-average .summary-icon-wrap { background: rgba(6, 182, 212, 0.1); }
    .card-average .summary-icon-wrap i { color: #06b6d4; }

    /* FILTER SECTION - Minimalis Clean */
    .filter-section {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .filter-header i {
        font-size: 18px;
        color: #4f46e5;
    }

    .filter-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1.2fr 1.2fr 1fr;
        gap: 16px;
        align-items: end;
    }

    @media(max-width: 1024px) {
        .filter-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media(max-width: 640px) {
        .filter-grid { grid-template-columns: 1fr; }
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 11px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        background: #fff;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .search-input-wrap {
        position: relative;
    }

    .search-input-wrap i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .search-input-wrap .form-control {
        padding-left: 44px;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-primary {
        background: #4f46e5;
        color: #fff;
        min-width: 100px;
    }

    .btn-primary:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-reset {
        background: #fff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        min-width: 48px;
    }

    .btn-reset:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* EXPORT BAR */
    .export-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .filter-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(79, 70, 229, 0.08);
        border-radius: 10px;
        font-size: 13px;
        color: #4f46e5;
        font-weight: 600;
    }

    .export-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-export {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-excel {
        background: #16a34a;
        color: #fff;
    }

    .btn-excel:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    .btn-pdf {
        background: #dc2626;
        color: #fff;
    }

    .btn-pdf:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* TABLE SECTION */
    .table-container {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .table-header {
        padding: 24px 28px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .table-count {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background: rgba(79, 70, 229, 0.08);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #4f46e5;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead tr {
        background: #f8fafc;
    }

    .table th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        background: #fafbfc;
    }

    .table td {
        padding: 18px 20px;
        font-size: 14px;
        color: #334155;
    }

    .transaction-number {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        font-weight: 700;
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.08);
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .transaction-nota {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
        display: block;
    }

    .date-display {
        font-weight: 600;
        color: #1e293b;
    }

    .time-display {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
        display: block;
    }

    .badge-payment {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-tunai {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .badge-transfer {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .badge-qris {
        background: rgba(168, 85, 247, 0.1);
        color: #7c3aed;
    }

    .total-amount {
        font-weight: 700;
        color: #0f172a;
        font-size: 15px;
    }

    .btn-detail {
        background: none;
        border: none;
        color: #4f46e5;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: rgba(79, 70, 229, 0.08);
    }

    .btn-detail i {
        transition: transform 0.2s;
    }

    .btn-detail.open i {
        transform: rotate(180deg);
    }

    /* DETAIL ROW */
    .detail-row td {
        background: #fafbfc;
        padding: 0 !important;
        border-top: 1px solid #e2e8f0;
    }

    .detail-inner {
        padding: 20px 28px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table thead tr {
        background: transparent;
        border-bottom: 2px solid #e2e8f0;
    }

    .detail-table th {
        padding: 10px 12px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-table td {
        padding: 12px;
        font-size: 13px;
        border-top: 1px solid #f1f5f9;
    }

    .product-code {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #64748b;
        background: rgba(100, 116, 139, 0.1);
        padding: 2px 8px;
        border-radius: 4px;
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: rgba(79, 70, 229, 0.08);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 36px;
        color: #4f46e5;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 20px;
    }

    /* PAGINATION */
    .pagination-wrap {
        padding: 20px 28px;
        border-top: 2px solid #f1f5f9;
    }

    /* RESPONSIVE */
    @media(max-width: 768px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .filter-section {
            padding: 20px;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .export-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .export-buttons {
            width: 100%;
        }

        .btn-export {
            flex: 1;
        }
    }
</style>
@endpush

@section('content')

{{-- HEADER SECTION --}}
<div class="content-header" style="margin-bottom: 32px;">
    <div>
        <h2 style="color:#1e293b; font-size:28px; font-weight:800; margin-bottom:6px;">
             Laporan Penjualan
        </h2>
        <p style="color:#64748b; font-size:14px; font-weight:500;">
            Rekap dan analisis seluruh transaksi penjualan koperasi
        </p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="summary-grid">
    <div class="summary-card card-transactions">
        <div class="summary-content">
            <div class="summary-info">
                <h3>Total Transaksi</h3>
                <div class="value">{{ number_format($summary->total_transaksi ?? 0) }}</div>
            </div>
            <div class="summary-icon-wrap">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>

    <div class="summary-card card-revenue">
        <div class="summary-content">
            <div class="summary-info">
                <h3>Total Pendapatan</h3>
                <div class="value" style="font-size:26px;">
                    Rp {{ number_format($summary->total_pendapatan ?? 0, 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-icon-wrap">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="summary-card card-average">
        <div class="summary-content">
            <div class="summary-info">
                <h3>Rata-rata / Transaksi</h3>
                <div class="value" style="font-size:26px;">
                    Rp {{ number_format($summary->rata_rata ?? 0, 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-icon-wrap">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
</div>

{{-- FILTER SECTION --}}
<div class="filter-section">
    <div class="filter-header">
        <i class="fas fa-sliders-h"></i>
        <h4>Filter & Pencarian</h4>
    </div>

    <form id="filterForm" action="{{ route('admin.laporan-penjualan.index') }}" method="GET">
        <div class="filter-grid">
            <div class="form-group">
                <label class="form-label">Pencarian</label>
                <div class="search-input-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari no. transaksi, member, produk..."
                        value="{{ request('search') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" class="form-control"
                    value="{{ request('tanggal_dari') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" class="form-control"
                    value="{{ request('tanggal_sampai') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_bayar" class="form-control">
                    <option value="">Semua Metode</option>
                    <option value="tunai" {{ request('metode_bayar')=='tunai' ? 'selected':'' }}>Tunai</option>
                    <option value="transfer" {{ request('metode_bayar')=='transfer' ? 'selected':'' }}>Transfer</option>
                    <option value="qris" {{ request('metode_bayar')=='qris' ? 'selected':'' }}>QRIS</option>
                </select>
            </div>
        </div>

        <div class="filter-actions" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Terapkan Filter
            </button>
            <a href="{{ route('admin.laporan-penjualan.index') }}" class="btn btn-reset" title="Reset Filter">
                <i class="fas fa-redo-alt"></i>
            </a>
        </div>
    </form>
</div>

{{-- EXPORT BAR --}}
<div class="export-bar">
    <div>
        @if(request()->hasAny(['search','tanggal_dari','tanggal_sampai','metode_bayar']))
            <div class="filter-indicator">
                <i class="fas fa-filter"></i>
                Filter aktif diterapkan
            </div>
        @endif
    </div>

    <div class="export-buttons">
        <a href="{{ route('admin.laporan-penjualan.excel', request()->all()) }}" class="btn-export btn-excel">
            <i class="fas fa-file-excel"></i>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan-penjualan.pdf', request()->all()) }}" target="_blank" class="btn-export btn-pdf">
            <i class="fas fa-file-pdf"></i>
            Cetak PDF
        </a>
    </div>
</div>

{{-- TABLE SECTION --}}
<div class="table-container">
    <div class="table-header">
        <h3 class="table-title">
            Data Transaksi
            <span class="table-count">{{ $transaksi->total() }} data</span>
        </h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal & Waktu</th>
                    <th>Kasir</th>
                    <th>Member</th>
                    <th>Metode</th>
                    <th style="text-align:right;">Total</th>
                    <th style="text-align:center; width:100px;">Detail</th>
                </tr>
            </thead>
            <tbody id="mainTbody">
                @forelse($transaksi as $i => $t)
                <tr>
                    <td style="color:#94a3b8; font-weight:600;">
                        {{ ($transaksi->currentPage()-1) * $transaksi->perPage() + $i + 1 }}
                    </td>
                    <td>
                        <span class="transaction-number">{{ $t->no_transaksi }}</span>
                        @if($t->no_nota)
                            <small class="transaction-nota">{{ $t->no_nota }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="date-display">{{ $t->dibuat_pada?->format('d/m/Y') }}</span>
                        <small class="time-display">{{ $t->dibuat_pada?->format('H:i') }} WIB</small>
                    </td>
                    <td>{{ $t->kasir->name ?? '-' }}</td>
                    <td>{{ $t->member->name ?? 'Umum' }}</td>
                    <td>
                        @php $m = strtolower($t->metode_bayar); @endphp
                        <span class="badge-payment badge-{{ $m }}">
                            @if($m==='tunai')
                                <i class="fas fa-money-bill"></i>
                            @elseif($m==='transfer')
                                <i class="fas fa-building-columns"></i>
                            @else
                                <i class="fas fa-qrcode"></i>
                            @endif
                            {{ ucfirst($m) }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <span class="total-amount">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                    </td>
                    <td style="text-align:center;">
                        <button class="btn-detail" onclick="toggleDetail(this, {{ $t->id }})" data-open="0">
                            <i class="fas fa-chevron-down"></i>
                            Lihat
                        </button>
                    </td>
                </tr>

                {{-- Detail Row --}}
                <tr class="detail-row" id="detail-{{ $t->id }}" style="display:none;">
                    <td colspan="8">
                        <div class="detail-inner">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kode</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th style="text-align:right;">Harga Satuan</th>
                                        <th style="text-align:right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($t->detail as $d)
                                    <tr>
                                        <td>{{ $d->produk->nama ?? '-' }}</td>
                                        <td><span class="product-code">{{ $d->produk->kode_produk ?? '-' }}</span></td>
                                        <td style="text-align:center; font-weight:600;">{{ $d->jumlah }}</td>
                                        <td style="text-align:right;">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                        <td style="text-align:right; font-weight:700; color:#0f172a;">
                                            Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5>Tidak Ada Data</h5>
                            <p>Tidak ada transaksi yang sesuai dengan filter yang dipilih.</p>
                            <a href="{{ route('admin.laporan-penjualan.index') }}" class="btn btn-primary">
                                <i class="fas fa-redo-alt"></i>
                                Reset Filter
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    {{ $transaksi->links('vendor.pagination.custom') }}
</div>

@endsection

@push('scripts')
<script>
function toggleDetail(btn, id) {
    const row = document.getElementById('detail-' + id);
    const isOpen = btn.dataset.open === '1';

    if (isOpen) {
        row.style.display = 'none';
        btn.innerHTML = '<i class="fas fa-chevron-down"></i> Lihat';
        btn.dataset.open = '0';
        btn.classList.remove('open');
    } else {
        row.style.display = 'table-row';
        btn.innerHTML = '<i class="fas fa-chevron-up"></i> Tutup';
        btn.dataset.open = '1';
        btn.classList.add('open');
    }
}

// Preserve filter params on pagination
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pagination a').forEach(a => {
        const url = new URL(a.href);
        const form = document.getElementById('filterForm');
        if (form) {
            new FormData(form).forEach((v, k) => {
                if (v) url.searchParams.set(k, v);
            });
            a.href = url.toString();
        }
    });
});
</script>
@endpush