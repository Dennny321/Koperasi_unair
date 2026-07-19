@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('breadcrumb', 'Sistem / Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Log Aktivitas </h2>
        <p style="color: var(--text-secondary);">Rekaman seluruh aktivitas pengguna di sistem</p>
    </div>

    @if($stats['deletable'] > 0)
    <form action="{{ route('admin.activity-log.purge-old') }}" method="POST"
          onsubmit="return confirm('Hapus {{ $stats['deletable'] }} log yang sudah berumur lebih dari 3 bulan? Tindakan ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash-alt"></i>
            Hapus Log Lama ({{ $stats['deletable'] }})
        </button>
    </form>
    @endif
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="alert alert-warning"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
@endif

{{-- Statistik --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 20px; border-radius: 12px; color: white; display: flex; align-items: center; gap: 16px;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-calendar-day" style="font-size: 22px;"></i>
        </div>
        <div>
            <p style="font-size: 12px; opacity: 0.85; margin: 0 0 2px;">Hari Ini</p>
            <h3 style="font-size: 26px; font-weight: 800; margin: 0;">{{ number_format($stats['total_today']) }}</h3>
        </div>
    </div>

    <div style="background: linear-gradient(135deg, var(--success), #059669); padding: 20px; border-radius: 12px; color: white; display: flex; align-items: center; gap: 16px;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-calendar-week" style="font-size: 22px;"></i>
        </div>
        <div>
            <p style="font-size: 12px; opacity: 0.85; margin: 0 0 2px;">7 Hari Terakhir</p>
            <h3 style="font-size: 26px; font-weight: 800; margin: 0;">{{ number_format($stats['total_week']) }}</h3>
        </div>
    </div>

    <div style="background: linear-gradient(135deg, var(--info), #2563eb); padding: 20px; border-radius: 12px; color: white; display: flex; align-items: center; gap: 16px;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-database" style="font-size: 22px;"></i>
        </div>
        <div>
            <p style="font-size: 12px; opacity: 0.85; margin: 0 0 2px;">Total Log</p>
            <h3 style="font-size: 26px; font-weight: 800; margin: 0;">{{ number_format($stats['total_all']) }}</h3>
        </div>
    </div>

    <div style="background: linear-gradient(135deg, var(--warning), #d97706); padding: 20px; border-radius: 12px; color: white; display: flex; align-items: center; gap: 16px;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-hourglass-end" style="font-size: 22px;"></i>
        </div>
        <div>
            <p style="font-size: 12px; opacity: 0.85; margin: 0 0 2px;">Bisa Dihapus (>3 bln)</p>
            <h3 style="font-size: 26px; font-weight: 800; margin: 0;">{{ number_format($stats['deletable']) }}</h3>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <form action="{{ route('admin.activity-log.index') }}" method="GET">
        <div class="filter-grid">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Nama user, deskripsi, modul, IP..." value="{{ request('search') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Aksi</label>
                <select name="action" class="form-control">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Modul</label>
                <select name="module" class="form-control">
                    <option value="">Semua Modul</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') === $module ? 'selected' : '' }}>
                            {{ $module }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">User</label>
                <select name="user_id" class="form-control">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <div style="display: flex; gap: 8px; align-items: flex-end;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.activity-log.index') }}" class="btn btn-warning" style="flex: 1;">
                    <i class="fas fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Tabel Log --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Log Aktivitas ({{ $logs->total() }})</h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 110px;">Waktu</th>
                    <th>User</th>
                    <th style="width: 110px;">Aksi</th>
                    <th>Modul</th>
                    <th>Deskripsi</th>
                    <th style="width: 120px;">IP Address</th>
                    <th style="width: 80px; text-align:center;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $logs->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                            {{ $log->created_at->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 11px; color: var(--text-secondary);">
                            {{ $log->created_at->format('H:i:s') }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--text-main);">{{ $log->user_name ?? '-' }}</div>
                        @if($log->user_role)
                            <span class="badge badge-info" style="font-size: 10px; padding: 2px 8px;">{{ $log->user_role }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $log->action_badge }}" style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px;">
                            <i class="fas {{ $log->action_icon }}" style="font-size: 11px;"></i>
                            {{ $log->action_label }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: var(--primary);">{{ $log->module }}</span>
                        @if($log->subject_label)
                            <div style="font-size: 12px; color: var(--text-secondary);">{{ Str::limit($log->subject_label, 30) }}</div>
                        @endif
                    </td>
                    <td style="max-width: 280px;">
                        <span style="font-size: 13px; color: var(--text-main);">{{ Str::limit($log->description, 60) }}</span>
                    </td>
                    <td>
                        <span style="font-size: 12px; font-family: monospace; color: var(--text-secondary);">
                            {{ $log->ip_address ?? '-' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.activity-log.show', $log->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 40px;">
                        <i class="fas fa-clipboard-list" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px; display: block;"></i>
                        <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada log aktivitas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $logs->links('vendor.pagination.custom') }}
</div>
@endsection
