@extends('layouts.app')

@section('title', 'Detail User')
@section('breadcrumb', 'Admin / User / Detail')
@section('page-title', 'Detail User')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail User</h2>
            <p style="color: var(--text-secondary);">Informasi lengkap akun <strong>{{ $user->name }}</strong></p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <a href="{{ route('admin.user.index') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi User</h3>
        </div>

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">

                {{-- ── KOLOM KIRI ── --}}
                <div>

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="form-control-static">{{ $user->name }}</div>
                    </div>

                    {{-- Username --}}
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="form-control-static">{{ $user->username }}</div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="form-control-static">{{ $user->email }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div style="margin-top: 4px;">
                            @php
                                $roleConfig = [
                                    'admin' => [
                                        'color' => '#dc3545',
                                        'bg' => 'rgba(220,53,69,.1)',
                                        'icon' => 'fa-shield-alt',
                                        'label' => 'Admin',
                                    ],
                                    'kasir' => [
                                        'color' => '#fd7e14',
                                        'bg' => 'rgba(253,126,20,.1)',
                                        'icon' => 'fa-cash-register',
                                        'label' => 'Kasir',
                                    ],
                                    'member' => [
                                        'color' => '#28a745',
                                        'bg' => 'rgba(40,167,69,.1)',
                                        'icon' => 'fa-user',
                                        'label' => 'Member',
                                    ],
                                ];
                                $r = $roleConfig[$user->role] ?? [
                                    'color' => 'var(--text-secondary)',
                                    'bg' => 'var(--bg-body)',
                                    'icon' => 'fa-circle',
                                    'label' => ucfirst($user->role),
                                ];
                            @endphp
                            <span
                                style="display:inline-flex; align-items:center; gap:6px;
                                         background:{{ $r['bg'] }}; color:{{ $r['color'] }};
                                         padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600;">
                                <i class="fas {{ $r['icon'] }}"></i>
                                {{ $r['label'] }}
                            </span>
                        </div>
                    </div>

                </div>

                {{-- ── KOLOM KANAN ── --}}
                <div>

                    {{-- Bergabung --}}
                    <div class="form-group mt-2">
                        <label class="form-label">Bergabung Sejak</label>
                        <div class="form-control-static">
                            {{ $user->created_at->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>

                    {{-- Terakhir diperbarui --}}
                    <div class="form-group">
                        <label class="form-label">Terakhir Diperbarui</label>
                        <div class="form-control-static">
                            {{ $user->updated_at->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── RIWAYAT POIN (member only) ── --}}
            @if ($user->role === 'member' && $user->riwayatPoin->isNotEmpty())
                <div style="margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                    <h5 style="font-weight:700; color:var(--primary); margin-bottom:16px;">
                        <i class="fas fa-history"></i> Riwayat Poin Terakhir
                    </h5>
                    <div style="overflow-x:auto;">
                        <table class="table" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Keterangan</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->riwayatPoin as $i => $riwayat)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $riwayat->keterangan ?? '—' }}</td>
                                        <td>
                                            @if (($riwayat->jumlah ?? 0) >= 0)
                                                <span style="color:#28a745; font-weight:600;">
                                                    +{{ number_format($riwayat->jumlah) }}
                                                </span>
                                            @else
                                                <span style="color:#dc3545; font-weight:600;">
                                                    {{ number_format($riwayat->jumlah) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $riwayat->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- ── ACTION BUTTONS ── --}}
            <div
                style="display:flex; gap:12px; margin-top:32px; padding-top:24px; border-top:2px solid var(--bg-body); flex-wrap:wrap;">
                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit"></i>
                    Edit User
                </a>

                @if ($user->id !== auth()->id())
                    {{-- Hapus --}}
                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                        onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="fas fa-trash"></i>
                            Hapus User
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.user.index') }}" class="btn btn-warning btn-lg" style="margin-left:auto;">
                    <i class="fas fa-times"></i>
                    Kembali
                </a>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .form-control-static {
                padding: 10px 14px;
                background: var(--bg-body);
                border: 1px solid var(--border-color);
                border-radius: var(--radius);
                font-size: 14px;
                color: var(--text-primary);
                min-height: 42px;
                display: flex;
                align-items: center;
            }
        </style>
    @endpush
@endsection
