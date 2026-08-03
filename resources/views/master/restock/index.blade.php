@extends('layouts.app')


@section('title', 'Data Restock')
@section('breadcrumb', 'Master / Restock')
@section('page-title', 'Data Restock')


@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Restock</h2>
            <p style="color: var(--text-secondary);">Kelola semua data restock produk Anda di sini</p>
        </div>
        <a href="{{ route('admin.restock.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Restock
        </a>
    </div>


    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route('admin.restock.index') }}" method="GET" id="filterForm">
            <div class="filter-grid" style="grid-template-columns: repeat(5, 1fr);">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Cari Restock</label>
                    <input type="text" name="search" class="form-control" placeholder="Kode restock atau keterangan..."
                        value="{{ request('search') }}">
                </div>


                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Supplier</label>
                    <select name="supplier" class="form-control">
                        <option value="">Semua Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>


                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>


                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>


            <div style="display: flex; gap: 8px; margin-top: 16px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.restock.index') }}" class="btn btn-warning" style="flex: 1;">
                    <i class="fas fa-rotate-right"></i> Reset
                </a>
            </div>
        </form>
    </div>


    <!-- Card Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Restock ({{ $restocks->total() }})</h3>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.restock.export.excel', request()->query()) }}" class="btn btn-success btn-sm"
                    title="Export ke Excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.restock.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm"
                    target="_blank" title="Export ke PDF">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Kode Restock</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th style="width: 200px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restocks as $item)
                        <tr>
                            <td>{{ $restocks->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $item->kode_restock }}</strong></td>
                            <td>
                                    {{ $item->tanggal_restock ? \Carbon\Carbon::parse($item->tanggal_restock)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td>
                                @if ($item->supplier)
                                    <span class="badge badge-info">{{ $item->supplier->nama }}</span>
                                @else
                                    <span class="badge badge-secondary">Tanpa Supplier</span>
                                @endif
                            </td>
                            <td><strong style="color: var(--success);">{{ $item->total_biaya_formatted }}</strong></td>
                            <td>
                                @if ($item->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($item->status == 'draft')
                                    <span class="badge badge-warning">Draft</span>
                                @else
                                    <span class="badge badge-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('admin.restock.show', $item->id) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    @if ($item->status == 'draft')
                                        <a href="{{ route('admin.restock.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        <form action="{{ route('admin.restock.approve', $item->id) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Approve restock ini? Stok produk akan bertambah.')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>


                                        <form action="{{ route('admin.restock.destroy', $item->id) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus restock ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif


                                    @if ($item->status == 'draft')
                                        <form action="{{ route('admin.restock.cancel', $item->id) }}" method="POST"
                                            style="display: inline;" onsubmit="return confirm('Batalkan restock ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm" title="Batalkan">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 40px;">
                                <i class="fas fa-inbox"
                                    style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                                <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data restock</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{ $restocks->links('vendor.pagination.custom') }}
    </div>
@endsection
