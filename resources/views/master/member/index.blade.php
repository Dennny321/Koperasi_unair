@extends('layouts.app')

@section('title', 'Data Member')
@section('breadcrumb', 'Master / Member')
@section('page-title', 'Data Member')

@section('content')
@php $prefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Member </h2>
        <p style="color: var(--text-secondary);">Kelola semua data member koperasi di sini</p>
    </div>
    <a href="{{ route($prefix.'.member.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Member
    </a>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route($prefix.'.member.index') }}" method="GET" id="filterForm">
        <div class="filter-grid">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cari Member</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau no. telepon..." value="{{ request('search') }}">
            </div>

            <div style="display: flex; gap: 8px; align-items: flex-end;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route($prefix.'.member.index') }}" class="btn btn-warning" style="flex: 1;">
                    <i class="fas fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Card Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Member ({{ $members->total() }})</h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Member</th>
                    <th>No. Telepon</th>
                    <th>Saldo Poin</th>
                    <th>Terdaftar</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $item)
                <tr>
                    <td>{{ $members->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 15px; flex-shrink: 0;">
                                {{ strtoupper(substr($item->name, 0, 1)) }}
                            </div>
                            <strong>{{ $item->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $item->no_telepon }}</td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-coins"></i> {{ number_format($item->saldo_poin) }} Poin
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            <a href="{{ route($prefix.'.member.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route($prefix.'.member.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route($prefix.'.member.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?')">
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
                        <i class="fas fa-users" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data member</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $members->links('vendor.pagination.custom') }}
</div>
@endsection