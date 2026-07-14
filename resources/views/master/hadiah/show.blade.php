@extends('layouts.app')

@section('title', 'Detail Hadiah')
@section('breadcrumb', 'Master / Hadiah / Detail')
@section('page-title', 'Detail Hadiah')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Hadiah</h2>
        <p style="color: var(--text-secondary);">Informasi lengkap hadiah</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.hadiah.edit', $hadiah->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit
        </a>
        <a href="{{ route('admin.hadiah.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Informasi Hadiah -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Hadiah</h3>
            @if($hadiah->tersedia())
                <span class="badge badge-success">
                    <i class="fas fa-check-circle"></i> Tersedia
                </span>
            @else
                <span class="badge badge-danger">
                    <i class="fas fa-times-circle"></i> Tidak Tersedia
                </span>
            @endif
        </div>

        <div style="padding: 24px;">
            <div style="display: grid; gap: 20px;">
                <!-- Nama -->
                <div>
                    <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">Nama Hadiah</p>
                    <p style="margin: 6px 0 0; font-size: 20px; font-weight: 700; color: var(--text-main);">
                        {{ $hadiah->nama }}
                    </p>
                </div>

                <!-- Stats Grid -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div style="padding: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; color: white;">
                        <p style="margin: 0; font-size: 13px; opacity: 0.9;">Biaya Poin</p>
                        <p style="margin: 8px 0 0; font-size: 24px; font-weight: 700;">
                            <i class="fas fa-coins"></i> {{ number_format($hadiah->biaya_poin, 0, ',', '.') }}
                        </p>
                    </div>

                    <div style="padding: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; color: white;">
                        <p style="margin: 0; font-size: 13px; opacity: 0.9;">Stok Tersedia</p>
                        <p style="margin: 8px 0 0; font-size: 24px; font-weight: 700;">
                            <i class="fas fa-box"></i> {{ $hadiah->stok }}
                        </p>
                    </div>

                    <div style="padding: 16px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; color: white;">
                        <p style="margin: 0; font-size: 13px; opacity: 0.9;">Total Penukaran</p>
                        <p style="margin: 8px 0 0; font-size: 24px; font-weight: 700;">
                            <i class="fas fa-exchange-alt"></i> {{ $hadiah->penukaran->count() }}
                        </p>
                    </div>

                    <div style="padding: 16px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; color: white;">
                        <p style="margin: 0; font-size: 13px; opacity: 0.9;">Status</p>
                        <p style="margin: 8px 0 0; font-size: 24px; font-weight: 700;">
                            @if($hadiah->aktif)
                                <i class="fas fa-check-circle"></i> Aktif
                            @else
                                <i class="fas fa-times-circle"></i> Non-Aktif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Tambahan -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Info Tambahan</h3>
            </div>

            <div style="padding: 20px;">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">
                            <i class="fas fa-calendar-plus"></i> Dibuat
                        </p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: var(--text-main);">
                            {{ $hadiah->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">
                            <i class="fas fa-calendar-edit"></i> Terakhir Diupdate
                        </p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: var(--text-main);">
                            {{ $hadiah->updated_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">
                            <i class="fas fa-hashtag"></i> ID Hadiah
                        </p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: var(--text-main);">
                            #{{ $hadiah->id }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card" style="margin-top: 16px;">
            <div class="card-header">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>

            <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('admin.hadiah.edit', $hadiah->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Hadiah
                </a>

                <form action="{{ route('admin.hadiah.destroy', $hadiah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hadiah ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-trash"></i> Hapus Hadiah
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Penukaran -->
@if($hadiah->penukaran->count() > 0)
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">Riwayat Penukaran ({{ $hadiah->penukaran->count() }})</h3>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Member</th>
                    <th>Poin Digunakan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hadiah->penukaran->take(10) as $index => $penukaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penukaran->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        @if($penukaran->member)
                            <strong>{{ $penukaran->member->nama }}</strong>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-coins"></i> {{ number_format($hadiah->biaya_poin, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-success">Selesai</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
