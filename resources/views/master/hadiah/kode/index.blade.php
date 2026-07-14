@extends('layouts.app')

@section('title', 'Kode Hadiah — ' . $hadiah->nama)

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3730a3 0%, #4f46e5 100%);
        --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    }

    /* PAGE HEADER */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        gap: 20px;
    }

    .page-header-left h1 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .page-header-left p {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .btn-back {
        background: #fff;
        color: #64748b;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
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
        justify-content: space-between;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1.5px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        color: #991b1b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        opacity: 0.5;
        transition: opacity 0.2s;
    }

    .btn-close:hover {
        opacity: 1;
    }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-gradient);
    }

    .stat-card.card-info::before { background: var(--info-gradient); }
    .stat-card.card-success::before { background: var(--success-gradient); }
    .stat-card.card-warning::before { background: var(--warning-gradient); }
    .stat-card.card-danger::before { background: var(--danger-gradient); }

    .stat-card-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--icon-bg);
        flex-shrink: 0;
    }

    .stat-icon-wrap i {
        font-size: 24px;
        color: var(--icon-color);
    }

    .card-info .stat-icon-wrap { background: rgba(6, 182, 212, 0.1); }
    .card-info .stat-icon-wrap i { color: #06b6d4; }

    .card-success .stat-icon-wrap { background: rgba(16, 185, 129, 0.1); }
    .card-success .stat-icon-wrap i { color: #10b981; }

    .card-warning .stat-icon-wrap { background: rgba(245, 158, 11, 0.1); }
    .card-warning .stat-icon-wrap i { color: #f59e0b; }

    .card-danger .stat-icon-wrap { background: rgba(239, 68, 68, 0.1); }
    .card-danger .stat-icon-wrap i { color: #ef4444; }

    .stat-info h3 {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .stat-info .value {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* CARD CUSTOM */
    .card-custom {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        height: 100%;
    }

    .card-custom-header {
        padding: 24px 28px;
        border-bottom: 2px solid #f1f5f9;
    }

    .card-custom-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-custom-title i {
        color: #4f46e5;
        font-size: 20px;
    }

    .card-custom-body {
        padding: 28px;
    }

    /* FORM ELEMENTS */
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

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-text {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
    }

    /* BUTTONS */
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
        background: var(--primary-gradient);
        color: #fff;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-outline-danger {
        background: #fff;
        color: #dc2626;
        border: 1.5px solid #fca5a5;
    }

    .btn-outline-danger:hover {
        background: #fef2f2;
        border-color: #f87171;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 8px;
    }

    .w-100 {
        width: 100%;
    }

    /* ALERT BOX */
    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        border: 1.5px solid rgba(245, 158, 11, 0.3);
        border-radius: 10px;
        padding: 12px 16px;
        color: #92400e;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-warning i {
        color: #f59e0b;
    }

    .text-muted {
        color: #94a3b8;
    }

    .small {
        font-size: 13px;
    }

    /* TABLE */
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
        vertical-align: middle;
    }

    .table code {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        font-weight: 700;
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.08);
        padding: 4px 10px;
        border-radius: 6px;
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

    .bg-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .bg-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .bg-secondary {
        background: rgba(100, 116, 139, 0.1);
        color: #475569;
    }

    .text-dark {
        color: #d97706 !important;
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
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

    .empty-state p {
        font-size: 14px;
        color: #64748b;
    }

    /* PAGINATION */
    .pagination-wrap {
        padding: 16px 28px;
        border-top: 2px solid #f1f5f9;
    }

    /* GRID SYSTEM */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-3, .col-lg-4, .col-lg-8 {
        padding: 0 10px;
    }

    .col-md-3 {
        width: 25%;
    }

    .col-lg-4 {
        width: 33.333%;
    }

    .col-lg-8 {
        width: 66.667%;
    }

    .g-3 {
        margin: 0 -6px;
    }

    .g-3 > * {
        padding: 0 6px;
    }

    .g-4 {
        margin: 0 -8px;
    }

    .g-4 > * {
        padding: 0 8px;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    .mb-4 {
        margin-bottom: 24px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    hr {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 20px 0;
    }

    /* RESPONSIVE */
    @media(max-width: 992px) {
        .col-lg-4, .col-lg-8 {
            width: 100%;
            margin-bottom: 20px;
        }
    }

    @media(max-width: 768px) {
        .col-md-3 {
            width: 50%;
            margin-bottom: 12px;
        }

        .page-header {
            flex-direction: column;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 576px) {
        .col-md-3 {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-left">
        <h1>🎁 Kode Hadiah</h1>
        <p>{{ $hadiah->nama }} — Stok: <strong>{{ $hadiah->stok }}</strong></p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.hadiah.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

{{-- ALERTS --}}
@if(session('success'))
<div class="alert-success">
    <span>{!! session('success') !!}</span>
    <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
</div>
@endif

@if(session('error'))
<div class="alert-danger">
    <span>{{ session('error') }}</span>
    <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
</div>
@endif

{{-- STATS CARDS --}}
<div class="stats-grid">
    <div class="stat-card card-info">
        <div class="stat-card-content">
            <div class="stat-icon-wrap">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <h3>Total Generated</h3>
                <div class="value">{{ $jumlahGenerated }}</div>
            </div>
        </div>
    </div>

    <div class="stat-card card-success">
        <div class="stat-card-content">
            <div class="stat-icon-wrap">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Kode Tersedia</h3>
                <div class="value">{{ $jumlahTersedia }}</div>
            </div>
        </div>
    </div>

    <div class="stat-card card-warning">
        <div class="stat-card-content">
            <div class="stat-icon-wrap">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h3>Sudah Diredeem</h3>
                <div class="value">{{ $jumlahDiredeem }}</div>
            </div>
        </div>
    </div>

    <div class="stat-card card-danger">
        <div class="stat-card-content">
            <div class="stat-icon-wrap">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>Perlu Generate</h3>
                <div class="value">{{ $sisaPerluGenerate }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- PANEL GENERATE --}}
    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-custom-header">
                <h5 class="card-custom-title">
                    <i class="fas fa-magic"></i>
                    Generate Kode Baru
                </h5>
            </div>
            <div class="card-custom-body">
                <p class="text-muted small mb-3">
                    Stok hadiah saat ini: <strong>{{ $hadiah->stok }}</strong><br>
                    Kode tersedia: <strong>{{ $jumlahTersedia }}</strong>
                </p>

                @if($sisaPerluGenerate > 0)
                <div class="alert-warning mb-3">
                    <i class="fas fa-info-circle"></i>
                    <span>Masih ada <strong>{{ $sisaPerluGenerate }}</strong> stok tanpa kode.</span>
                </div>
                @endif

                <form action="{{ route('admin.hadiah.kode.generate', $hadiah) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jumlah Kode yang Di-generate</label>
                        <input
                            type="number"
                            name="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah', $sisaPerluGenerate > 0 ? $sisaPerluGenerate : 1) }}"
                            min="1"
                            max="500"
                            required
                        >
                        @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Setiap 1 kode = 1 pemakaian hadiah.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-magic"></i>
                        Generate Kode
                    </button>
                </form>

                @if($jumlahTersedia > 0)
                <hr>
                <form action="{{ route('admin.hadiah.kode.destroy-all', $hadiah) }}" method="POST"
                    onsubmit="return confirm('Hapus semua {{ $jumlahTersedia }} kode tersedia? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                        <i class="fas fa-trash"></i>
                        Hapus Semua Kode Tersedia
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- TABLE KODE --}}
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-custom-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h5 class="card-custom-title">
                    <i class="fas fa-list"></i>
                    Daftar Kode Hadiah
                </h5>
                <span class="badge bg-secondary">{{ $kode->total() }} kode</span>
            </div>
            <div class="card-custom-body" style="padding:0;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Kode Hadiah</th>
                                <th>Poin</th>
                                <th>Status</th>
                                <th>Diredeem Oleh</th>
                                <th>Tanggal</th>
                                <th style="width:80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kode as $k)
                            <tr>
                                <td class="text-muted small">
                                    {{ $loop->iteration + ($kode->currentPage() - 1) * $kode->perPage() }}
                                </td>
                                <td>
                                    <code>{{ $k->kode_hadiah }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ number_format($k->jumlah_poin) }} poin
                                    </span>
                                </td>
                                <td>
                                    @if($k->status === 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                    @else
                                    <span class="badge bg-secondary">Diredeem</span>
                                    @endif
                                </td>
                                <td class="small">
                                    @if($k->member)
                                    <i class="fas fa-user" style="color:#94a3b8; margin-right:6px;"></i>{{ $k->member->name }}
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $k->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="text-align:center;">
                                    @if($k->isTersedia())
                                    <form action="{{ route('admin.hadiah.kode.destroy', [$hadiah, $k]) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Hapus kode {{ $k->kode_hadiah }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm" 
                                            style="background:rgba(239,68,68,0.1); color:#dc2626; border:none; cursor:pointer; transition:all 0.2s;"
                                            onmouseover="this.style.background='#ef4444'; this.style.color='#fff';"
                                            onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#dc2626';"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <p>Belum ada kode yang di-generate.<br>Gunakan form di sebelah kiri untuk membuat kode baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($kode->hasPages())
                <div class="pagination-wrap">
                    {{ $kode->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection