@extends('layouts.app')

@section('title', 'Detail Produk')
@section('breadcrumb', 'Master / Produk / Detail')
@section('page-title', 'Detail Produk')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Produk</h2>
            <p style="color: var(--text-secondary);">Informasi lengkap produk</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                Edit Produk
            </a>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 350px 1fr; gap: 24px;">
        <!-- Card Foto Produk -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Foto Produk</h3>
            </div>
            <div style="padding: 24px; text-align: center;">
                @if ($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                        style="width: 100%; max-width: 300px; border-radius: 12px; border: 3px solid var(--border-color); box-shadow: var(--shadow-card);">
                @else
                    <div
                        style="width: 100%; height: 300px; background: var(--bg-body); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 3px dashed var(--border-color);">
                        <i class="fas fa-image"
                            style="font-size: 64px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-secondary); font-weight: 600;">Tidak ada foto</p>
                    </div>
                @endif

                <!-- Status Badge -->
                <div style="margin-top: 20px;">
                    @if ($produk->status == 'aktif')
                        <span class="badge badge-success" style="padding: 10px 20px; font-size: 14px;">
                            <i class="fas fa-check-circle"></i> Status: Aktif
                        </span>
                    @else
                        <span class="badge badge-danger" style="padding: 10px 20px; font-size: 14px;">
                            <i class="fas fa-times-circle"></i> Status: Non-Aktif
                        </span>
                    @endif
                </div>

                <!-- Stock Warning -->
                @if ($produk->stok <= $produk->stok_minimum)
                    <div class="alert alert-warning" style="margin-top: 20px; text-align: left;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan Stok!</strong><br>
                        Stok produk sudah mencapai batas minimum atau kurang.
                    </div>
                @endif
            </div>
        </div>

        <!-- Card Informasi Produk -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Produk</h3>
                <div style="display: flex; gap: 8px;">
                    <button class="btn btn-success btn-sm" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-info btn-sm">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>

            <div style="padding: 24px;">
                <!-- Detail Table -->
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; width: 200px; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-barcode" style="margin-right: 8px; color: var(--primary);"></i>
                            Kode Produk
                        </td>
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                            {{ $produk->kode_produk }}
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-box" style="margin-right: 8px; color: var(--primary);"></i>
                            Nama Produk
                        </td>
                        <td style="padding: 16px 0; font-weight: 700; color: var(--primary); font-size: 18px;">
                            {{ $produk->nama }}
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-tag" style="margin-right: 8px; color: var(--primary);"></i>
                            Kategori
                        </td>
                        <td style="padding: 16px 0;">
                            @if ($produk->kategori)
                                <span class="badge badge-info" style="padding: 8px 16px; font-size: 13px;">
                                    {{ $produk->kategori->nama }}
                                </span>
                            @else
                                <span class="badge badge-danger">Tidak ada kategori</span>
                            @endif
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: var(--primary);"></i>
                            Harga
                        </td>
                        <td style="padding: 16px 0;">
                            <span style="font-size: 24px; font-weight: 800; color: var(--success);">
                                {{ $produk->harga_formatted }}
                            </span>
                            <span style="font-size: 14px; color: var(--text-secondary); margin-left: 8px;">
                                / {{ $produk->satuan }}
                            </span>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-cubes" style="margin-right: 8px; color: var(--primary);"></i>
                            Stok Tersedia
                        </td>
                        <td style="padding: 16px 0;">
                            @if ($produk->stok <= $produk->stok_minimum)
                                <span style="font-size: 32px; font-weight: 800; color: var(--danger);">
                                    {{ $produk->stok }}
                                </span>
                            @else
                                <span style="font-size: 32px; font-weight: 800; color: var(--success);">
                                    {{ $produk->stok }}
                                </span>
                            @endif
                            <span style="font-size: 14px; color: var(--text-secondary); margin-left: 8px;">
                                {{ $produk->satuan }}
                            </span>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 8px; color: var(--primary);"></i>
                            Stok Minimum
                        </td>
                        <td style="padding: 16px 0;">
                            <span style="font-size: 20px; font-weight: 700; color: var(--warning);">
                                {{ $produk->stok_minimum }}
                            </span>
                            <span style="font-size: 14px; color: var(--text-secondary); margin-left: 8px;">
                                {{ $produk->satuan }}
                            </span>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-balance-scale" style="margin-right: 8px; color: var(--primary);"></i>
                            Satuan
                        </td>
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                            {{ $produk->satuan }}
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-truck" style="margin-right: 8px; color: var(--primary);"></i>
                            Supplier Terakhir
                        </td>
                        <td style="padding: 16px 0;">
                            @php $supplierTerakhir = $produk->supplierTerakhir(); @endphp
                            @if ($supplierTerakhir)
                                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                    <span style="font-weight: 700; color: var(--text-main);">
                                        {{ $supplierTerakhir->nama }}
                                    </span>
                                    @if ($supplierTerakhir->status === 'aktif')
                                        <span class="badge badge-success" style="font-size: 11px;">Aktif</span>
                                    @else
                                        <span class="badge badge-danger" style="font-size: 11px;">Non-Aktif</span>
                                    @endif
                                </div>
                                <div style="margin-top: 6px; display: flex; flex-wrap: wrap; gap: 16px;">
                                    @if ($supplierTerakhir->telepon)
                                        <span style="font-size: 13px; color: var(--text-secondary);">
                                            <i class="fas fa-phone" style="margin-right: 4px;"></i>
                                            {{ $supplierTerakhir->telepon }}
                                        </span>
                                    @endif
                                    @if ($supplierTerakhir->email)
                                        <span style="font-size: 13px; color: var(--text-secondary);">
                                            <i class="fas fa-envelope" style="margin-right: 4px;"></i>
                                            {{ $supplierTerakhir->email }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">
                                    <i class="fas fa-minus-circle" style="margin-right: 4px;"></i>
                                    Belum ada data restock
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-history" style="margin-right: 8px; color: var(--primary);"></i>
                            Semua Supplier
                        </td>
                        <td style="padding: 16px 0;">
                            @php $semuaSupplier = $produk->suppliers(); @endphp
                            @if ($semuaSupplier->isNotEmpty())
                                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                    @foreach ($semuaSupplier as $supplier)
                                        <span
                                            style="
                                        display: inline-flex; align-items: center; gap: 6px;
                                        background: var(--primary-light); color: var(--primary);
                                        border: 1px solid rgba(47,50,145,0.15);
                                        border-radius: 100px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                                            <i class="fas fa-truck" style="font-size: 10px;"></i>
                                            {{ $supplier->nama }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">—</span>
                            @endif
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-calendar-plus" style="margin-right: 8px; color: var(--primary);"></i>
                            Dibuat Pada
                        </td>
                        <td style="padding: 16px 0; color: var(--text-main);">
                            {{ $produk->created_at->format('d F Y, H:i') }} WIB
                            <span style="font-size: 12px; color: var(--text-secondary);">
                                ({{ $produk->created_at->diffForHumans() }})
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                            <i class="fas fa-calendar-check" style="margin-right: 8px; color: var(--primary);"></i>
                            Terakhir Diupdate
                        </td>
                        <td style="padding: 16px 0; color: var(--text-main);">
                            {{ $produk->updated_at->format('d F Y, H:i') }} WIB
                            <span style="font-size: 12px; color: var(--text-secondary);">
                                ({{ $produk->updated_at->diffForHumans() }})
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Action Buttons -->
                <div
                    style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                    <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i>
                        Edit Produk
                    </a>

                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                        style="display: inline;"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="fas fa-trash"></i>
                            Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Statistik Produk (Optional) -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <h3 class="card-title">Statistik & Informasi Tambahan</h3>
        </div>
        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <!-- Total Nilai Stok -->
                <div
                    style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 24px; border-radius: 12px; color: white;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div
                            style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-dollar-sign" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">Total Nilai Stok</p>
                            <h3 style="font-size: 20px; font-weight: 800; margin: 0;">
                                Rp {{ number_format($produk->harga * $produk->stok, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Persentase Stok -->
                <div
                    style="background: linear-gradient(135deg, var(--success), #059669); padding: 24px; border-radius: 12px; color: white;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div
                            style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-percentage" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">Persentase Stok</p>
                            <h3 style="font-size: 20px; font-weight: 800; margin: 0;">
                                @php
                                    $persentase =
                                        $produk->stok_minimum > 0 ? ($produk->stok / $produk->stok_minimum) * 100 : 100;
                                @endphp
                                {{ number_format($persentase, 1) }}%
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Status Ketersediaan -->
                <div
                    style="background: linear-gradient(135deg, var(--warning), #d97706); padding: 24px; border-radius: 12px; color: white;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div
                            style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes-stacked" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">Ketersediaan</p>
                            <h3 style="font-size: 20px; font-weight: 800; margin: 0;">
                                @if ($produk->stok > 0)
                                    Tersedia
                                @else
                                    Habis
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Harga Per Unit -->
                <div
                    style="background: linear-gradient(135deg, var(--info), #2563eb); padding: 24px; border-radius: 12px; color: white;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div
                            style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-tag" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">Harga/{{ $produk->satuan }}</p>
                            <h3 style="font-size: 20px; font-weight: 800; margin: 0;">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {

            .sidebar,
            .top-navbar,
            .content-header,
            .btn,
            .card-header>div {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 0 !important;
            }

            .content-body {
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                page-break-inside: avoid;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Optional: Auto refresh stok status
        setInterval(function() {
            // You can add AJAX call here to refresh stock status
        }, 30000); // Refresh every 30 seconds
    </script>
@endpush
