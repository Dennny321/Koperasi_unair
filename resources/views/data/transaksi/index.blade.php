@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('breadcrumb', 'Transaksi')
@section('page-title', 'Data Transaksi')

@section('content')
    @php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Riwayat Transaksi</h2>
            <p style="color: var(--text-secondary);">Pantau semua transaksi koperasi</p>
        </div>
        <a href="{{ route($rp . '.transaksi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Transaksi Baru
        </a>
    </div>

    <!-- Summary Hari Ini -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0;">
            <div style="padding: 20px; display: flex; align-items: center; gap: 16px;">
                <div
                    style="width: 50px; height: 50px; border-radius: 12px; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; flex-shrink: 0;">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <div style="font-size: 13px; color: var(--text-secondary);">Transaksi Hari Ini</div>
                    <div style="font-size: 24px; font-weight: 700; color: var(--text-main);">
                        {{ $summaryHariIni->total_transaksi ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-bottom: 0;">
            <div style="padding: 20px; display: flex; align-items: center; gap: 16px;">
                <div
                    style="width: 50px; height: 50px; border-radius: 12px; background: var(--success); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; flex-shrink: 0;">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <div style="font-size: 13px; color: var(--text-secondary);">Pendapatan Hari Ini</div>
                    <div style="font-size: 24px; font-weight: 700; color: var(--text-main);">
                        Rp {{ number_format($summaryHariIni->total_pendapatan ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route($rp . '.transaksi.index') }}" method="GET">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control"
                        placeholder="No. transaksi atau nama member..." value="{{ request('search') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Metode Bayar</label>
                    <select name="metode_bayar" class="form-control">
                        <option value="">Semua Metode</option>
                        <option value="tunai" {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>Transfer
                        </option>
                        <option value="qris" {{ request('metode_bayar') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="form-control"
                        value="{{ request('tanggal_sampai') }}">
                </div>

                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route($rp . '.transaksi.index') }}" class="btn btn-warning" style="flex: 1;">
                        <i class="fas fa-rotate-right"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi ({{ $transaksi->total() }})</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No. Transaksi</th>
                        <th>Kasir</th>
                        <th>Member</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th style="width: 100px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                        <tr>
                            <td>{{ $transaksi->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $item->no_transaksi }}</strong></td>
                            <td>{{ $item->kasir?->name ?? '-' }}</td>
                            <td>
                                @if ($item->member)
                                    <span class="badge badge-info">
                                        <i class="fas fa-user"></i> {{ $item->member->name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-secondary); font-size: 13px;">Umum</span>
                                @endif
                            </td>
                            <td><strong style="color: var(--success);">{{ $item->total_harga_formatted }}</strong></td>
                            <td>
                                @php
                                    $metodeBadge = [
                                        'tunai' => ['badge-success', 'fa-money-bill-wave', 'Tunai'],
                                        'transfer' => ['badge-info', 'fa-university', 'Transfer'],
                                        'qris' => ['badge-warning', 'fa-qrcode', 'QRIS'],
                                    ];
                                    $badge = $metodeBadge[$item->metode_bayar] ?? [
                                        'badge-secondary',
                                        'fa-circle',
                                        $item->metode_bayar,
                                    ];
                                @endphp
                                <span class="badge {{ $badge[0] }}">
                                    <i class="fas {{ $badge[1] }}"></i> {{ $badge[2] }}
                                </span>
                            </td>
                            <td>
                                @if ($item->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-danger">Batal</span>
                                @endif
                            </td>
                            <td style="font-size: 13px; color: var(--text-secondary);">
                                {{ $item->dibuat_pada->format('d M Y H:i') }}
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route($rp . '.transaksi.show', $item->id) }}" class="btn btn-info btn-sm"
                                        title="Lihat Struk">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($item->status == 'selesai')
                                        <form action="{{ route($rp . '.transaksi.destroy', $item->id) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Batalkan">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center" style="padding: 40px;">
                                <i class="fas fa-receipt"
                                    style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                                <p style="color: var(--text-secondary); font-size: 16px;">Belum ada data transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $transaksi->links('vendor.pagination.custom') }}
    </div>
@endsection
