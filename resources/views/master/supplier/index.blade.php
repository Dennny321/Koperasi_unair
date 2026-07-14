@extends('layouts.app')


@section('title', 'Data Supplier')
@section('breadcrumb', 'Master / Supplier')
@section('page-title', 'Data Supplier')


@section('content')
<div class="content-header">
   <div>
       <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Supplier</h2>
       <p style="color: var(--text-secondary);">Kelola semua data supplier Anda di sini</p>
   </div>
   <a href="{{ route('admin.supplier.create') }}" class="btn btn-primary">
       <i class="fas fa-plus"></i>
       Tambah Supplier
   </a>
</div>


<!-- Filter Bar -->
<div class="filter-bar">
   <form action="{{ route('admin.supplier.index') }}" method="GET" id="filterForm">
       <div class="filter-grid">
           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label">Cari Supplier</label>
               <input type="text" name="search" class="form-control" placeholder="Nama, kode, telepon, atau email..." value="{{ request('search') }}">
           </div>


           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label">Status</label>
               <select name="status" class="form-control">
                   <option value="">Semua Status</option>
                   <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                   <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
               </select>
           </div>


           <div style="display: flex; gap: 8px;">
               <button type="submit" class="btn btn-primary" style="flex: 1;">
                   <i class="fas fa-search"></i> Filter
               </button>
               <a href="{{ route('admin.supplier.index') }}" class="btn btn-warning" style="flex: 1;">
                   <i class="fas fa-rotate-right"></i> Reset
               </a>
           </div>
       </div>
   </form>
</div>


<!-- Card Table -->
<div class="card">
   <div class="card-header">
       <h3 class="card-title">Daftar Supplier ({{ $suppliers->total() }})</h3>
   </div>


   <div class="table-responsive">
       <table class="table">
           <thead>
               <tr>
                   <th style="width: 60px;">No</th>
                   <th>Kode Supplier</th>
                   <th>Nama Supplier</th>
                   <th>Telepon</th>
                   <th>Email</th>
                   <th>Alamat</th>
                   <th>Status</th>
                   <th style="width: 150px; text-align: center;">Aksi</th>
               </tr>
           </thead>
           <tbody>
               @forelse($suppliers as $item)
               <tr>
                   <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                   <td><strong>{{ $item->kode_supplier }}</strong></td>
                   <td>{{ $item->nama }}</td>
                   <td>
                       @if($item->telepon)
                           <i class="fas fa-phone" style="color: var(--success);"></i>
                           {{ $item->telepon }}
                       @else
                           <span style="color: var(--text-secondary);">-</span>
                       @endif
                   </td>
                   <td>
                       @if($item->email)
                           <i class="fas fa-envelope" style="color: var(--info);"></i>
                           {{ $item->email }}
                       @else
                           <span style="color: var(--text-secondary);">-</span>
                       @endif
                   </td>
                   <td>
                       @if($item->alamat)
                           {{ Str::limit($item->alamat, 30) }}
                       @else
                           <span style="color: var(--text-secondary);">-</span>
                       @endif
                   </td>
                   <td>
                       @if($item->status == 'aktif')
                           <span class="badge badge-success">Aktif</span>
                       @else
                           <span class="badge badge-danger">Non-Aktif</span>
                       @endif
                   </td>
                   <td>
                       <div style="display: flex; gap: 6px; justify-content: center;">
                           <a href="{{ route('admin.supplier.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                               <i class="fas fa-eye"></i>
                           </a>
                           <a href="{{ route('admin.supplier.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                               <i class="fas fa-edit"></i>
                           </a>
                           <form action="{{ route('admin.supplier.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
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
                   <td colspan="8" class="text-center" style="padding: 40px;">
                       <i class="fas fa-building" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                       <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data supplier</p>
                   </td>
               </tr>
               @endforelse
           </tbody>
       </table>
   </div>


   {{ $suppliers->links('vendor.pagination.custom') }}
</div>
@endsection




