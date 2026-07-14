@extends('layouts.app')

@section('title', 'Data Produk')
@section('breadcrumb', 'Master / Produk')
@section('page-title', 'Data Produk')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Produk</h2>
        <p style="color: var(--text-secondary);">Kelola semua data produk Anda di sini</p>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Produk
    </a>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route('admin.produk.index') }}" method="GET" id="filterForm">
        <div class="filter-grid">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cari Produk</label>
                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Ketik nama/kode atau scan barcode..." value="{{ request('search') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Filter Stok</label>
                <select name="stok_minimal" class="form-control">
                    <option value="">Semua Stok</option>
                    <option value="1" {{ request('stok_minimal') ? 'selected' : '' }}>Stok Minimal</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-warning" style="flex: 1;">
                    <i class="fas fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Card Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Produk ({{ $produk->total() }})</h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 80px;">Foto</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $item)
                <tr>
                    <td>{{ $produk->firstItem() + $loop->index }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="img-thumbnail">
                        @else
                            <div style="width: 60px; height: 60px; background: var(--bg-body); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: var(--text-secondary);"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $item->kode_produk }}</strong></td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @if($item->kategori)
                            <span class="badge badge-info">{{ $item->kategori->nama }}</span>
                        @else
                            <span class="badge badge-danger">No Category</span>
                        @endif
                    </td>
                    <td><strong style="color: var(--success);">{{ $item->harga_formatted }}</strong></td>
                    <td>
                        @if($item->stok <= $item->stok_minimum)
                            <span class="badge badge-danger">{{ $item->stok }}</span>
                        @else
                            <span class="badge badge-success">{{ $item->stok }}</span>
                        @endif
                    </td>
                    <td>{{ $item->satuan }}</td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            <a href="{{ route('admin.produk.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
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
                    <td colspan="10" class="text-center" style="padding: 40px;">
                        <i class="fas fa-box-open" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data produk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $produk->links('vendor.pagination.custom') }}
</div>
@endsection

@push('scripts')
<script>
    // ===========================
    // KEYBOARD BARCODE SCANNER untuk SEARCH
    // Scanner akan otomatis mengisi field search dan submit form
    // ===========================
    (function() {
        let barcodeBuffer = '';
        let barcodeTimer  = null;
        const searchInput = document.getElementById('searchInput');
        const filterForm  = document.getElementById('filterForm');

        document.addEventListener('keydown', function(e) {
            // Hanya aktif jika fokus di searchInput atau tidak di input/select lain
            const activeElement = document.activeElement;
            const isInOtherInput = (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA' || activeElement.tagName === 'SELECT')
                                    && activeElement.id !== 'searchInput';

            if (isInOtherInput) return;

            if (e.key === 'Enter') {
                // Enter = akhir dari scan barcode
                if (barcodeBuffer.length >= 3) {
                    e.preventDefault();
                    searchInput.value = barcodeBuffer.trim();

                    // Visual feedback
                    searchInput.style.borderColor = '#10b981';
                    searchInput.style.backgroundColor = '#d1fae5';

                    showToast('🔍 Mencari produk: ' + barcodeBuffer.trim(), 'success');

                    // Auto submit form setelah 500ms
                    setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                }
                barcodeBuffer = '';
                if (barcodeTimer) clearTimeout(barcodeTimer);
                return;
            }

            // Karakter printable (hanya jika tidak fokus di input lain)
            if (e.key.length === 1 && activeElement.id !== 'searchInput') {
                barcodeBuffer += e.key;
                // Reset buffer jika tidak ada input dalam 200ms (bukan scanner, tapi keyboard biasa)
                if (barcodeTimer) clearTimeout(barcodeTimer);
                barcodeTimer = setTimeout(() => { barcodeBuffer = ''; }, 200);
            }
        });

        // Juga tangkap input langsung di field search
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });
    })();

    // Toast Notification
    function showToast(msg, type = 'success') {
        const existing = document.getElementById('produkToast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'produkToast';
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
</script>
@endpush