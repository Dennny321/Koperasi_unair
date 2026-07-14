@extends('layouts.app')

@section('title', 'Surat Jalan - Koperasi UNAIR')
@section('breadcrumb', 'Data / Surat Jalan')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3730a3 0%, #4f46e5 100%);
        --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
        --purple-gradient: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
    }

    /* PAGE HEADER */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        gap: 20px;
    }

    .header-content h2 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-content h2 i {
        color: #4f46e5;
        font-size: 26px;
    }

    .header-content p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .btn-create {
        background: var(--primary-gradient);
        color: #fff;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        color: #fff;
    }

    /* ALERTS */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1.5px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        color: #065f46;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success i {
        font-size: 20px;
        color: #10b981;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1.5px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        color: #991b1b;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-error i {
        font-size: 20px;
        color: #ef4444;
    }

    /* FILTER SECTION */
    .filter-section {
        background: #fff;
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr auto;
        gap: 16px;
        align-items: end;
    }

    @media(max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
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
    }

    .btn-primary:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-outline-secondary {
        background: #fff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* TABLE CONTAINER */
    .table-container {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f8fafc;
    }

    .data-table th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }

    .data-table tbody tr:hover {
        background: #fafbfc;
    }

    .data-table td {
        padding: 18px 20px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }

    .surat-number {
        font-weight: 700;
        color: #4f46e5;
        font-size: 14px;
        display: block;
        margin-bottom: 4px;
    }

    .transaksi-number {
        font-size: 12px;
        color: #94a3b8;
        font-family: 'Courier New', monospace;
    }

    .text-muted {
        color: #94a3b8;
    }

    .text-center {
        text-align: center;
    }

    .small {
        font-size: 13px;
    }

    /* BADGES */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-items {
        background: rgba(168, 85, 247, 0.1);
        color: #7c3aed;
    }

    .badge-draft {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .badge-dicetak {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .badge-selesai {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    /* ACTION BUTTONS */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        text-decoration: none;
    }

    .btn-info {
        background: rgba(6, 182, 212, 0.1);
        color: #0891b2;
    }

    .btn-info:hover {
        background: #06b6d4;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-print {
        background: rgba(124, 58, 237, 0.1);
        color: #7c3aed;
    }

    .btn-print:hover {
        background: #7c3aed;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .btn-warning:hover {
        background: #f59e0b;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .btn-danger:hover {
        background: #ef4444;
        color: #fff;
        transform: translateY(-2px);
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
    }

    /* PAGINATION */
    .pagination-wrap {
        padding: 20px 28px;
        border-top: 2px solid #f1f5f9;
    }

    /* RESPONSIVE */
    @media(max-width: 768px) {
        .page-header {
            flex-direction: column;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .data-table {
            font-size: 13px;
        }

        .data-table th,
        .data-table td {
            padding: 12px 14px;
        }
    }
</style>
@endpush

@section('content')
@php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="header-content">
        <h2>
            <i class="fas fa-file-alt"></i>
            Surat Jalan
        </h2>
        <p>Kelola surat jalan & cetak invoice pengiriman barang</p>
    </div>
    <a href="{{ route($rp.'.surat-jalan.create') }}" class="btn-create">
        <i class="fas fa-plus"></i>
        Buat Surat Jalan
    </a>
</div>

{{-- ALERTS --}}
@if(session('success'))
<div class="alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- FILTER SECTION --}}
<div class="filter-section">
    <form action="{{ route($rp.'.surat-jalan.index') }}" method="GET">
        <div class="filter-grid">
            <div class="form-group">
                <label class="form-label">Pencarian</label>
                <input type="text" name="search" class="form-control"
                    placeholder="Cari no surat, tujuan..."
                    value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="dicetak" {{ request('status') === 'dicetak' ? 'selected' : '' }}>Dicetak</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route($rp.'.surat-jalan.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo-alt"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th>No Surat</th>
                <th>Tujuan</th>
                <th>Kasir</th>
                <th style="text-align:center;">Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th style="width:180px; text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratJalan as $item)
            <tr>
                <td style="color:#94a3b8; font-weight:600;">
                    {{ $suratJalan->firstItem() + $loop->index }}
                </td>
                <td>
                    <span class="surat-number">{{ $item->no_surat }}</span>
                    <span class="transaksi-number">{{ $item->no_transaksi }}</span>
                </td>
                <td>
                    <strong style="color:#1e293b;">{{ $item->tujuan }}</strong>
                </td>
                <td class="small text-muted">
                    {{ $item->kasir?->name ?? '—' }}
                </td>
                <td class="text-center">
                    <span class="badge badge-items">
                        {{ $item->detail_count }} item
                    </span>
                </td>
                <td>
                    <strong style="color:#0f172a; font-size:15px;">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </strong>
                </td>
                <td>
                    @php
                        $badgeClass = match($item->status) {
                            'draft'   => 'badge-draft',
                            'dicetak' => 'badge-dicetak',
                            'selesai' => 'badge-selesai',
                            default   => 'badge-draft',
                        };
                        $statusLabel = match($item->status) {
                            'draft'   => 'Draft',
                            'dicetak' => 'Dicetak',
                            'selesai' => 'Selesai',
                            default   => ucfirst($item->status),
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                </td>
                <td class="small text-muted">
                    {{ $item->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route($rp.'.surat-jalan.show', $item) }}"
                            class="btn-sm btn-info" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route($rp.'.surat-jalan.cetak', $item) }}"
                            class="btn-sm btn-print" title="Cetak PDF" target="_blank">
                            <i class="fas fa-print"></i>
                        </a>
                        @if($item->status === 'draft')
                            <a href="{{ route($rp.'.surat-jalan.edit', $item) }}"
                                class="btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route($rp.'.surat-jalan.destroy', $item) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Hapus surat jalan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5>Belum Ada Data</h5>
                        <p>Belum ada surat jalan yang dibuat.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $suratJalan->links('vendor.pagination.custom') }}
</div>

@endsection