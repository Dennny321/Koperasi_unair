@extends('layouts.app')

@section('title', 'Detail Kategori Produk')
@section('breadcrumb', 'Master / Kategori Produk / Detail')
@section('page-title', 'Detail Kategori Produk')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Kategori Produk</h2>
        <p style="color: var(--text-secondary);">Informasi lengkap kategori produk</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.kategori-produk.edit', $kategoriProduk->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit
        </a>
        <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Info Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Kategori</h3>
        </div>

        <div style="padding: 24px;">
            <!-- Ikon Besar -->
            <div style="text-align: center; margin-bottom: 24px;">
                @if($kategoriProduk->ikon)
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-light, rgba(var(--primary-rgb), 0.1)) 0%, var(--primary-light, rgba(var(--primary-rgb), 0.2)) 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="{{ $kategoriProduk->ikon }}" style="font-size: 56px; color: var(--primary);"></i>
                    </div>
                @else
                    <div style="width: 120px; height: 120px; background: var(--bg-body); border: 2px dashed var(--border-color); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-tag" style="font-size: 56px; color: var(--text-secondary);"></i>
                    </div>
                @endif
                <h3 style="color: var(--text-primary); margin-bottom: 8px;">{{ $kategoriProduk->nama }}</h3>
                <p style="color: var(--text-secondary); font-size: 14px;">
                    {{ $kategoriProduk->keterangan ?? 'Tidak ada keterangan' }}
                </p>
            </div>

            <!-- Info Detail -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 20px;">
                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Kode Ikon</label>
                    <p style="margin-top: 4px; color: var(--text-primary); font-family: 'Courier New', monospace; background: var(--bg-body); padding: 8px 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                        {{ $kategoriProduk->ikon ?? '-' }}
                    </p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Jumlah Produk</label>
                    <p style="margin-top: 4px;">
                        <span class="badge badge-primary" style="font-size: 16px; padding: 8px 16px;">
                            {{ $kategoriProduk->produk_count }} Produk
                        </span>
                    </p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Dibuat Pada</label>
                    <p style="margin-top: 4px; color: var(--text-primary);">
                        <i class="fas fa-calendar" style="color: var(--text-secondary); margin-right: 6px;"></i>
                        {{ $kategoriProduk->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                <div>
                    <label style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Terakhir Diubah</label>
                    <p style="margin-top: 4px; color: var(--text-primary);">
                        <i class="fas fa-clock" style="color: var(--text-secondary); margin-right: 6px;"></i>
                        {{ $kategoriProduk->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Produk dalam Kategori Ini ({{ $kategoriProduk->produk_count }})</h3>
            @if($kategoriProduk->produk_count > 0)
            <a href="{{ route('admin.produk.index', ['kategori' => $kategoriProduk->id]) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i> Lihat Semua
            </a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 80px;">Foto</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th style="width: 100px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriProduk->produk as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                            @else
                                <div style="width: 50px; height: 50px; background: var(--bg-body); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                                    <i class="fas fa-image" style="color: var(--text-secondary);"></i>
                                </div>
                            @endif
                        </td>
                        <td><code>{{ $produk->kode_produk }}</code></td>
                        <td><strong>{{ $produk->nama }}</strong></td>
                        <td>
                            @if($produk->stok <= $produk->stok_minimum)
                                <span class="badge badge-danger">{{ $produk->stok }} {{ $produk->satuan }}</span>
                            @else
                                <span class="badge badge-success">{{ $produk->stok }} {{ $produk->satuan }}</span>
                            @endif
                        </td>
                        <td><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></td>
                        <td>
                            @if($produk->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('admin.produk.show', $produk->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 40px;">
                            <i class="fas fa-box-open" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                            <p style="color: var(--text-secondary); font-size: 16px; margin-bottom: 12px;">
                                Belum ada produk dalam kategori ini
                            </p>
                            <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Produk Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kategoriProduk->produk_count > 10)
        <div style="padding: 20px; border-top: 1px solid var(--border-color); text-align: center;">
            <p style="color: var(--text-secondary); margin-bottom: 12px;">
                Menampilkan 10 dari {{ $kategoriProduk->produk_count }} produk
            </p>
            <a href="{{ route('admin.produk.index', ['kategori' => $kategoriProduk->id]) }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Lihat Semua Produk
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Action Buttons -->
<div class="card" style="margin-top: 24px;">
    <div style="padding: 20px; display: flex; gap: 12px; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.kategori-produk.edit', $kategoriProduk->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Kategori
            </a>
            <a href="{{ route('admin.produk.create') }}?kategori={{ $kategoriProduk->id }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk ke Kategori Ini
            </a>
        </div>

        <form action="{{ route('admin.kategori-produk.destroy', $kategoriProduk->id) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? {{ $kategoriProduk->produk_count > 0 ? 'Kategori ini memiliki ' . $kategoriProduk->produk_count . ' produk!' : '' }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" {{ $kategoriProduk->produk_count > 0 ? 'disabled' : '' }}>
                <i class="fas fa-trash"></i>
                Hapus Kategori
                @if($kategoriProduk->produk_count > 0)
                    (Ada {{ $kategoriProduk->produk_count }} Produk)
                @endif
            </button>
        </form>
    </div>
</div>
@endsection