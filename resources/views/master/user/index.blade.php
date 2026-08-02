@extends('layouts.app')

@section('title', 'Manajemen User')
@section('breadcrumb', 'Admin / User')
@section('page-title', 'Manajemen User')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen User</h2>
            <p style="color: var(--text-secondary);">Kelola semua akun pengguna sistem di sini</p>
        </div>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah User
        </a>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
        {{-- Total --}}
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid var(--primary); border-radius: var(--radius); padding: 16px 18px;">
            <div
                style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-secondary); margin-bottom: 6px;">
                Total User</div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $stats['total'] }}
            </div>
            <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">semua role</div>
        </div>
        {{-- Admin --}}
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #dc3545; border-radius: var(--radius); padding: 16px 18px;">
            <div
                style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-secondary); margin-bottom: 6px;">
                Admin</div>
            <div style="font-size: 28px; font-weight: 800; color: #dc3545; line-height: 1;">{{ $stats['admin'] }}</div>
            <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">akses penuh</div>
        </div>
        {{-- Kasir --}}
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #fd7e14; border-radius: var(--radius); padding: 16px 18px;">
            <div
                style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-secondary); margin-bottom: 6px;">
                Kasir</div>
            <div style="font-size: 28px; font-weight: 800; color: #fd7e14; line-height: 1;">{{ $stats['kasir'] }}</div>
            <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">operator transaksi</div>
        </div>
    </div>

    {{-- ── FILTER BAR ── --}}
    <div class="filter-bar">
        <form action="{{ route('admin.user.index') }}" method="GET" id="filterForm">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Cari User</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, email, atau no. telepon..."
                        value="{{ request('search') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-warning" style="flex: 1;">
                        <i class="fas fa-rotate-right"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ── FLASH MESSAGES ── --}}
    @if (session('success'))
        <div class="alert alert-success" style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ── TABLE CARD ── --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar User ({{ $users->total() }})</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th style="text-align: center;">Role</th>
                        <th>Bergabung</th>
                        <th style="width: 160px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $item)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>

                            {{-- Nama + avatar inisial --}}
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="
                                width: 34px; height: 34px; border-radius: 50%;
                                background: {{ $item->isAdmin() ? '#fde8e8' : ($item->isKasir() ? '#fff3e0' : '#e8f5e9') }};
                                color: {{ $item->isAdmin() ? '#dc3545' : ($item->isKasir() ? '#fd7e14' : '#28a745') }};
                                display: flex; align-items: center; justify-content: center;
                                font-size: 13px; font-weight: 700; flex-shrink: 0;">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-primary);">{{ $item->name }}
                                        </div>
                                        @if ($item->id === auth()->id())
                                            <div style="font-size: 11px; color: var(--primary);">
                                                <i class="fas fa-circle" style="font-size: 7px;"></i> Anda
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                <i class="fas fa-envelope" style="color: var(--info); font-size: 12px;"></i>
                                {{ $item->email }}
                            </td>

                            <td>
                                @if ($item->no_telepon)
                                    <i class="fas fa-phone" style="color: var(--success); font-size: 12px;"></i>
                                    {{ $item->no_telepon }}
                                @else
                                    <span style="color: var(--text-secondary);">-</span>
                                @endif
                            </td>

                            {{-- Role badge --}}
                            <td style="text-align: center;">
                                @if ($item->isAdmin())
                                    <span class="badge"
                                        style="background:#fde8e8; color:#dc3545; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                        <i class="fas fa-shield-alt" style="font-size:10px;"></i> Admin
                                    </span>
                                @elseif($item->isKasir())
                                    <span class="badge"
                                        style="background:#fff3e0; color:#fd7e14; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                        <i class="fas fa-cash-register" style="font-size:10px;"></i> Kasir
                                    </span>
                                @else
                                    <span class="badge"
                                        style="background:#e8f5e9; color:#28a745; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                        <i class="fas fa-user" style="font-size:10px;"></i> Member
                                    </span>
                                @endif
                            </td>

                            <td style="font-size: 12px; color: var(--text-secondary);">
                                {{ $item->created_at->format('d/m/Y') }}
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <a href="{{ route('admin.user.show', $item->id) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Hapus --}}
                                    @if ($item->id !== auth()->id())
                                        <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Hapus user {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm" disabled title="Tidak bisa hapus akun sendiri"
                                            style="background:#e9ecef; color:#adb5bd; border:none; cursor:not-allowed;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 40px;">
                                <i class="fas fa-users"
                                    style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px; display:block;"></i>
                                <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada data user</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links('vendor.pagination.custom') }}
    </div>
@endsection