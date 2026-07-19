@extends('layouts.app')

@section('title', 'Detail Member')
@section('breadcrumb', 'Master / Member / Detail')
@section('page-title', 'Detail Member')

@section('content')
@php $prefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Member </h2>
        <p style="color: var(--text-secondary);">Informasi lengkap data member</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route($prefix.'.member.edit', $member->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route($prefix.'.member.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Info Member -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <h3 class="card-title">Informasi Member</h3>
        </div>
        <div style="padding: 24px;">
            <!-- Avatar -->
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 26px; flex-shrink: 0;">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <div>
                    <h3 style="margin: 0 0 4px; color: var(--text-main);">{{ $member->name }}</h3>
                    <span class="badge badge-success">Member Aktif</span>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: var(--text-secondary); width: 40%;">
                        <i class="fas fa-phone" style="width: 18px;"></i> No. Telepon
                    </td>
                    <td style="padding: 10px 0; font-weight: 600; color: var(--text-main);">{{ $member->no_telepon }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: var(--text-secondary);">
                        <i class="fas fa-coins" style="width: 18px;"></i> Saldo Poin
                    </td>
                    <td style="padding: 10px 0;">
                        <span style="font-size: 20px; font-weight: 700; color: var(--primary);">{{ number_format($member->saldo_poin) }}</span>
                        <span style="color: var(--text-secondary); font-size: 13px;"> poin</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: var(--text-secondary);">
                        <i class="fas fa-calendar-alt" style="width: 18px;"></i> Terdaftar
                    </td>
                    <td style="padding: 10px 0; color: var(--text-main);">{{ $member->created_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>

            <!-- Reset Password -->
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--border-color);">
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 12px;">
                    <i class="fas fa-key"></i> Reset password member ke nomor telepon jika lupa password.
                </p>
                <form action="" method="POST" onsubmit="return confirm('Reset password member ini ke nomor telepon?')">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fas fa-redo"></i> Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div class="card" style="margin-bottom: 0; flex: 1;">
            <div class="card-header">
                <h3 class="card-title">Statistik Transaksi</h3>
            </div>
            <div style="padding: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div style="background: var(--bg-body); border-radius: 10px; padding: 16px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 700; color: var(--primary);">
                        {{ $member->transaksiSebagaiMember->count() }}
                    </div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-top: 4px;">Total Transaksi</div>
                </div>
                <div style="background: var(--bg-body); border-radius: 10px; padding: 16px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 700; color: var(--success);">
                        {{ $member->penukaran->count() }}
                    </div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-top: 4px;">Penukaran Poin</div>
                </div>
            </div>
        </div>

        <!-- Riwayat Poin Terbaru -->
        <div class="card" style="margin-bottom: 0; flex: 2;">
            <div class="card-header">
                <h3 class="card-title">Riwayat Poin Terbaru</h3>
            </div>
            <div style="padding: 0 24px 24px;">
                @forelse($member->riwayatPoin->take(5) as $riwayat)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                    <div>
                        <div style="font-weight: 600; color: var(--text-main); font-size: 14px;">
                            {{ $riwayat->keterangan ?? '-' }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-secondary);">

                        </div>
                    </div>
                    <span style="font-weight: 700; {{ $riwayat->poin >= 0 ? 'color: var(--success)' : 'color: var(--danger)' }}">
                        {{ $riwayat->poin >= 0 ? '+' : '' }}{{ number_format($riwayat->poin) }} poin
                    </span>
                </div>
                @empty
                <div style="text-align: center; padding: 24px 0; color: var(--text-secondary);">
                    <i class="fas fa-history" style="font-size: 32px; margin-bottom: 8px; display: block;"></i>
                    Belum ada riwayat poin
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection