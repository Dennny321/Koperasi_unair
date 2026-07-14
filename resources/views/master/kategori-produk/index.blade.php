@extends('layouts.app')

@section('title', 'Data Kategori Produk')
@section('breadcrumb', 'Master / Kategori Produk')
@section('page-title', 'Data Kategori Produk')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Kategori Produk</h2>
            <p style="color: var(--text-secondary);">Kelola semua kategori produk Anda di sini</p>
        </div>
        <a href="{{ route('admin.kategori-produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Kategori
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route('admin.kategori-produk.index') }}" method="GET">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Cari Kategori</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama kategori..."
                        value="{{ request('search') }}">
                </div>

                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-warning" style="flex: 1;">
                        <i class="fas fa-rotate-right"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Card Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori Produk ({{ $kategoris->total() }})</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 80px; text-align: center;">Ikon</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Jumlah Produk</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $item)
                        <tr>
                            <td>{{ $kategoris->firstItem() + $loop->index }}</td>
                            <td style="text-align: center;">
                                @if ($item->ikon)
                                    <div
                                        style="width: 44px; height: 44px; background: var(--primary-light, rgba(var(--primary-rgb), 0.1)); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="{{ $item->ikon }}" style="font-size: 18px; color: var(--primary);"></i>
                                    </div>
                                @else
                                    <div
                                        style="width: 44px; height: 44px; background: var(--bg-body); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-tag" style="color: var(--text-secondary);"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td style="color: var(--text-secondary);">{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $item->produk_count }} Produk</span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('admin.kategori-produk.show', $item->id) }}"
                                        class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kategori-produk.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori-produk.destroy', $item->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Produk yang terkait akan kehilangan kategorinya.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 40px;">
                                <i class="fas fa-tags"
                                    style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                                <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data kategori produk</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $kategoris->links('vendor.pagination.custom') }}
    </div>
@endsection
