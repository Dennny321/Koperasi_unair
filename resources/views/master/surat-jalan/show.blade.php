@extends('layouts.app')

@section('title', 'Detail Surat Jalan — ' . $suratJalan->no_surat)
@section('breadcrumb', 'Data / Surat Jalan / Detail')

@section('content')
@php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
<style>
    .detail-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem;
    }
    
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .header-info h2 {
        color: #2c3e50;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .header-info p {
        color: #7f8c8d;
        font-size: 0.95rem;
        margin: 0;
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .btn-elegant {
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary-custom {
        background: #3498db;
        color: white;
    }
    
    .btn-primary-custom:hover {
        background: #2980b9;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25);
    }
    
    .btn-warning-custom {
        background: #f39c12;
        color: white;
    }
    
    .btn-warning-custom:hover {
        background: #e67e22;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.25);
    }
    
    .btn-outline-custom {
        background: white;
        color: #7f8c8d;
        border: 1.5px solid #e0e0e0;
    }
    
    .btn-outline-custom:hover {
        background: #f8f9fa;
        border-color: #bdc3c7;
        color: #2c3e50;
    }
    
    .alert-elegant {
        background: #d4edda;
        border-left: 4px solid #28a745;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #155724;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-elegant {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    
    .card-title {
        padding: 1.5rem 1.75rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .card-title h6 {
        color: #2c3e50;
        font-size: 1.125rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    
    .card-title i {
        color: #3498db;
        font-size: 1.25rem;
    }
    
    .card-body-elegant {
        padding: 1.75rem;
    }
    
    .info-grid {
        display: grid;
        gap: 1.25rem;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .info-label {
        color: #95a5a6;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .info-value {
        color: #2c3e50;
        font-weight: 600;
        text-align: right;
        max-width: 60%;
    }
    
    .badge-elegant {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .badge-draft {
        background: #fff8e1;
        color: #f57c00;
    }
    
    .badge-dicetak {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .badge-selesai {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .total-box {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        text-align: center;
    }
    
    .total-label {
        color: rgba(255,255,255,0.9);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }
    
    .total-amount {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
    }
    
    .btn-complete-elegant {
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.875rem 1.5rem;
        width: 100%;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.25rem;
        transition: all 0.2s ease;
    }
    
    .btn-complete-elegant:hover {
        background: #229954;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.25);
    }
    
    .table-elegant {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-elegant thead {
        background: #f8f9fa;
    }
    
    .table-elegant thead th {
        padding: 1rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #5a6c7d;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .table-elegant tbody td {
        padding: 1.125rem 1rem;
        border-bottom: 1px solid #f5f5f5;
        color: #2c3e50;
        font-size: 0.9375rem;
    }
    
    .table-elegant tbody tr:hover {
        background: #fafbfc;
    }
    
    .table-elegant tbody tr:last-child td {
        border-bottom: none;
    }
    
    .code-badge {
        background: #ecf0f1;
        color: #34495e;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        font-family: 'Courier New', monospace;
    }
    
    .qty-badge {
        background: #fff8e1;
        color: #f57c00;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.875rem;
        display: inline-block;
    }
    
    .table-elegant tfoot {
        background: #2c3e50;
    }
    
    .table-elegant tfoot td {
        padding: 1.25rem 1rem;
        color: white;
        font-weight: 800;
        font-size: 1.0625rem;
        border: none;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .btn-elegant {
            flex: 1;
            justify-content: center;
        }
        
        .total-amount {
            font-size: 1.5rem;
        }
        
        .info-value {
            max-width: 50%;
            font-size: 0.875rem;
        }
    }
</style>

<div class="detail-wrapper">
    @if(session('success'))
    <div class="alert-elegant">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="page-header">
        <div class="header-info">
            <h2>Detail Surat Jalan</h2>
            <p>{{ $suratJalan->no_surat }}</p>
        </div>
        <div class="header-actions">
            @if($suratJalan->status === 'draft')
                <a href="{{ route($rp.'.surat-jalan.edit', $suratJalan) }}" class="btn-elegant btn-warning-custom">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endif
            <a href="{{ route($rp.'.surat-jalan.cetak', $suratJalan) }}" target="_blank" class="btn-elegant btn-primary-custom">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
            <a href="{{ route($rp.'.surat-jalan.index') }}" class="btn-elegant btn-outline-custom">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- INFO SECTION --}}
        <div class="col-lg-4">
            <div class="card-elegant">
                <div class="card-title">
                    <h6>
                        <i class="fas fa-info-circle"></i>
                        Informasi Surat Jalan
                    </h6>
                </div>
                <div class="card-body-elegant">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">No Surat</span>
                            <span class="info-value">{{ $suratJalan->no_surat }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">No Transaksi</span>
                            <span class="info-value" style="font-size: 0.8125rem;">{{ $suratJalan->no_transaksi }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Tujuan</span>
                            <span class="info-value">{{ $suratJalan->tujuan }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Dibuat oleh</span>
                            <span class="info-value">{{ $suratJalan->kasir?->name ?? '—' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Tanggal</span>
                            <span class="info-value">{{ $suratJalan->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @php
                                    $badgeClass = match($suratJalan->status) {
                                        'draft'   => 'badge-draft',
                                        'dicetak' => 'badge-dicetak',
                                        'selesai' => 'badge-selesai',
                                        default   => '',
                                    };
                                @endphp
                                <span class="badge-elegant {{ $badgeClass }}">
                                    {{ ucfirst($suratJalan->status) }}
                                </span>
                            </span>
                        </div>
                        
                        @if($suratJalan->keterangan)
                        <div class="info-row">
                            <span class="info-label">Keterangan</span>
                            <span class="info-value" style="font-size: 0.8125rem;">{{ $suratJalan->keterangan }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="total-box">
                        <div class="total-label">Total Keseluruhan</div>
                        <div class="total-amount">Rp {{ number_format($suratJalan->total_harga, 0, ',', '.') }}</div>
                    </div>

                    @if($suratJalan->status === 'dicetak')
                        <form action="{{ route($rp.'.surat-jalan.update', $suratJalan) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="tujuan" value="{{ $suratJalan->tujuan }}">
                            <input type="hidden" name="keterangan" value="{{ $suratJalan->keterangan }}">
                            @foreach($suratJalan->detail as $i => $d)
                                <input type="hidden" name="produk[{{ $i }}][id_produk]" value="{{ $d->id_produk }}">
                                <input type="hidden" name="produk[{{ $i }}][jumlah]" value="{{ $d->jumlah }}">
                                <input type="hidden" name="produk[{{ $i }}][harga_satuan]" value="{{ $d->harga_satuan }}">
                            @endforeach
                            <input type="hidden" name="_status_override" value="selesai">
                            
                            <button type="submit" class="btn-complete-elegant" name="status_action" value="selesai">
                                <i class="fas fa-check-double"></i>
                                Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- PRODUCT TABLE --}}
        <div class="col-lg-8">
            <div class="card-elegant">
                <div class="card-title">
                    <h6>
                        <i class="fas fa-boxes"></i>
                        Daftar Barang ({{ $suratJalan->detail->count() }} item)
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table-elegant">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th style="text-align: right;">Harga Satuan</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratJalan->detail as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="code-badge">{{ $d->produk?->kode_produk ?? '—' }}</span>
                                </td>
                                <td style="font-weight: 600;">{{ $d->produk?->nama ?? 'Produk dihapus' }}</td>
                                <td style="text-align: center;">
                                    <span class="qty-badge">
                                        {{ $d->jumlah }} {{ $d->produk?->satuan }}
                                    </span>
                                </td>
                                <td style="text-align: right; font-weight: 600;">
                                    Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td style="text-align: right; font-weight: 700;">
                                    Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;">TOTAL</td>
                                <td style="text-align: right;">
                                    Rp {{ number_format($suratJalan->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection