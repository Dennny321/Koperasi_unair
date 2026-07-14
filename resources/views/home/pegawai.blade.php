@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Welcome Card --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Welcome, {{ auth()->user()->name }}!</h4>
                </div>
                <div class="card-body">
                    <p class="lead">Selamat datang di Dashboard Pegawai</p>
                    <p class="text-muted">Kelola data produk dan stok sesuai dengan tugas Anda</p>
                </div>
            </div>

            {{-- Status Alert --}}
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Pegawai Statistics --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title text-muted mb-1">Total Produk</h6>
                                    <h3 class="mb-0">{{ \App\Models\Produk::count() }}</h3>
                                </div>
                                <div class="text-primary" style="font-size: 2rem; opacity: 0.3;">
                                    <i class="bi bi-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title text-muted mb-1">Stok Minimal</h6>
                                    <h3 class="mb-0">{{ \App\Models\Produk::stokMinimal()->count() }}</h3>
                                </div>
                                <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title text-muted mb-1">Total Kategori</h6>
                                    <h3 class="mb-0">{{ \App\Models\KategoriProduk::count() }}</h3>
                                </div>
                                <div class="text-info" style="font-size: 2rem; opacity: 0.3;">
                                    <i class="bi bi-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products List --}}
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Produk</h5>
                            <a href="#" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(\App\Models\Produk::paginate(10) as $produk)
                                        <tr>
                                            <td><code>{{ $produk->kode_produk }}</code></td>
                                            <td>{{ $produk->nama }}</td>
                                            <td><span class="badge bg-secondary">{{ $produk->kategori->nama }}</span></td>
                                            <td>
                                                @if($produk->stok <= $produk->stok_minimum)
                                                    <span class="badge bg-danger">{{ $produk->stok }}</span>
                                                @elseif($produk->stok < $produk->stok_minimum * 1.5)
                                                    <span class="badge bg-warning">{{ $produk->stok }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ $produk->stok }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $produk->satuan ?? '-' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="#" class="btn btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{-- {{ $produk->links() }} --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    {{-- Quick Links --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Menu Cepat</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-arrow-up-circle me-2"></i> Update Stok
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-file-earmark me-2"></i> Lihat Kategori
                            </a>
                        </div>
                    </div>

                    {{-- Info Card --}}
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Info Penting</h6>
                            <p class="card-text small">
                                <strong>Perhatian:</strong> Produk dengan badge merah menunjukkan stok telah mencapai batas minimum. Segera lakukan pemesanan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #007bff;
    }
    .border-left-success {
        border-left: 4px solid #28a745;
    }
    .border-left-warning {
        border-left: 4px solid #ffc107;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8;
    }
</style>
@endsection