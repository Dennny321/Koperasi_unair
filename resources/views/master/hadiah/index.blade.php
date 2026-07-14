@extends('layouts.app')

@section('title', 'Data Hadiah')
@section('breadcrumb', 'Master / Hadiah')
@section('page-title', 'Data Hadiah')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Manajemen Hadiah</h2>
            <p style="color: var(--text-secondary);">Kelola data hadiah & konfirmasi penukaran member</p>
        </div>
        <a href="{{ route('admin.hadiah.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Hadiah
        </a>
    </div>

    @if (session('success'))
        <div
            style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:10px; padding:14px 18px; margin-bottom:16px; color:#065f46; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="font-size:18px;"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            style="background:#fee2e2; border:1px solid #fca5a5; border-radius:10px; padding:14px 18px; margin-bottom:16px; color:#991b1b; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-exclamation-circle" style="font-size:18px;"></i> {{ session('error') }}
        </div>
    @endif

    <!-- TABS -->
    <div style="display:flex; gap:0; margin-bottom:0; border-bottom:2px solid var(--border-color);">
        <button class="tab-btn active" onclick="switchTab('tabHadiah', this)" id="btnTabHadiah"
            style="padding:10px 24px; font-weight:700; font-size:14px; border:none; background:none; cursor:pointer; border-bottom:3px solid var(--primary); color:var(--primary); margin-bottom:-2px;">
            <i class="fas fa-gift"></i> Data Hadiah
        </button>
    </div>

    <!-- ========================= TAB 1: HADIAH ========================= -->
    <div id="tabHadiah">
        <!-- Filter Bar -->
        <div class="filter-bar" style="border-radius:0 0 12px 12px;">
            <form action="{{ route('admin.hadiah.index') }}" method="GET" id="filterForm">
                <div class="filter-grid">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Cari Hadiah</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama hadiah..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Status</label>
                        <select name="aktif" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('aktif') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Ketersediaan</label>
                        <select name="tersedia" class="form-control">
                            <option value="">Semua</option>
                            <option value="1" {{ request('tersedia') ? 'selected' : '' }}>Stok Tersedia</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.hadiah.index') }}" class="btn btn-warning" style="flex: 1;">
                            <i class="fas fa-rotate-right"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Hadiah ({{ $hadiah->total() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Nama Hadiah</th>
                            <th>Biaya Poin</th>
                            <th>Stok</th>
                            <th>Kode Tersedia</th>
                            <th>Status</th>
                            <th>Ketersediaan</th>
                            <th style="width:150px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hadiah as $item)
                            <tr>
                                <td>{{ $hadiah->firstItem() + $loop->index }}</td>
                                <td><strong>{{ $item->nama }}</strong></td>
                                <td>
                                    <span class="badge badge-warning" style="font-size:14px;">
                                        <i class="fas fa-coins"></i> {{ number_format($item->biaya_poin, 0, ',', '.') }}
                                        Poin
                                    </span>
                                </td>
                                <td>
                                    @if ($item->stok > 10)
                                        <span class="badge badge-success">{{ $item->stok }}</span>
                                    @elseif($item->stok > 0)
                                        <span class="badge badge-warning">{{ $item->stok }}</span>
                                    @else
                                        <span class="badge badge-danger">0</span>
                                    @endif
                                </td>
                                <td>
                                    @php $kodeCount = $item->kode_hadiah_tersedia_count ?? $item->jumlahKodeTersedia(); @endphp
                                    @if ($kodeCount >= $item->stok && $item->stok > 0)
                                        <span class="badge" style="background:#d1fae5; color:#065f46; font-weight:700;">
                                            <i
                                                class="fas fa-check-circle me-1"></i>{{ $kodeCount }}/{{ $item->stok }}
                                        </span>
                                    @elseif($kodeCount > 0)
                                        <span class="badge" style="background:#fef3c7; color:#92400e; font-weight:700;">
                                            <i
                                                class="fas fa-exclamation-triangle me-1"></i>{{ $kodeCount }}/{{ $item->stok }}
                                        </span>
                                    @else
                                        <span class="badge" style="background:#fee2e2; color:#991b1b; font-weight:700;">
                                            <i class="fas fa-times-circle me-1"></i>0/{{ $item->stok }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-danger' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($item->isTersedia())
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i>
                                            Tersedia</span>
                                    @else
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Tidak
                                            Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex; gap:6px; justify-content:center;">
                                        <a href="{{ route('admin.hadiah.kode.index', $item->id) }}" class="btn btn-sm"
                                            style="background:#7c3aed; color:#fff; border-radius:7px; padding:5px 10px; font-size:12px; font-weight:700;"
                                            title="Kelola Kode Hadiah">
                                            <i class="fas fa-ticket-alt"></i>
                                            <span class="ms-1">Kode
                                                @if (isset($item->kode_hadiah_tersedia_count))
                                                    <span
                                                        style="background:rgba(255,255,255,0.25); border-radius:10px; padding:0 5px; font-size:11px;">
                                                        {{ $item->kode_hadiah_tersedia_count }}
                                                    </span>
                                                @endif
                                            </span>
                                        </a>
                                        <a href="{{ route('admin.hadiah.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.hadiah.destroy', $item->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Hapus hadiah ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:40px; color:var(--text-secondary);">
                                    <i class="fas fa-gift"
                                        style="font-size:40px; margin-bottom:12px; display:block; opacity:.3;"></i>
                                    Tidak ada data hadiah
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $hadiah->links('vendor.pagination.custom') }}
        </div>
    </div>


    <script>
        function switchTab(tabId, btn) {
            // Sembunyikan semua tab
            document.getElementById('tabHadiah').style.display = 'none';
            document.getElementById('tabPenukaran').style.display = 'none';
            // Reset tombol
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.style.borderBottomColor = 'transparent';
                b.style.color = 'var(--text-secondary)';
            });
            // Aktifkan tab yang dipilih
            document.getElementById(tabId).style.display = 'block';
            btn.style.borderBottomColor = 'var(--primary)';
            btn.style.color = 'var(--primary)';
        }

        // Jika ada session error terkait penukaran, otomatis buka tab penukaran
        @if (session('success') && str_contains(session('success'), 'enkaran'))
            switchTab('tabPenukaran', document.getElementById('btnTabPenukaran'));
        @endif
    </script>
@endsection
