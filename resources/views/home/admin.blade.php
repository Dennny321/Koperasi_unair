@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('breadcrumb', 'Pages / Admin / Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ===== HEADER ===== --}}
<div class="content-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div>
        <h2 style="color:var(--primary);font-size:26px;margin-bottom:4px;">
            Selamat Datang, {{ auth()->user()->name }}! 👋
        </h2>
        <p style="color:var(--text-secondary);">Dashboard Administrator — Koperasi Pegawai UNAIR</p>
    </div>
    <div style="font-size:13px;color:var(--text-secondary);">
        <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d F Y, H:i') }}
    </div>
</div>

{{-- ===== STATS CARDS ROW 1: Transaksi ===== --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;">
    {{-- Transaksi Hari Ini --}}
    <div class="card" style="margin-bottom:0;border-left:4px solid var(--primary);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(47,50,145,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Transaksi Hari Ini</div>
                <div style="font-size:26px;font-weight:700;color:var(--primary);">{{ number_format($transaksiHariIni) }}</div>
            </div>
        </div>
    </div>

    {{-- Pendapatan Hari Ini --}}
    <div class="card" style="margin-bottom:0;border-left:4px solid var(--success);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(16,185,129,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--success);">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Pendapatan Hari Ini</div>
                <div style="font-size:18px;font-weight:700;color:var(--success);">
                    Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Bulan Ini --}}
    <div class="card" style="margin-bottom:0;border-left:4px solid var(--warning);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(245,158,11,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--warning);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Transaksi Bulan Ini</div>
                <div style="font-size:26px;font-weight:700;color:var(--warning);">{{ number_format($transaksibulanIni) }}</div>
            </div>
        </div>
    </div>

    {{-- Pendapatan Bulan Ini --}}
    <div class="card" style="margin-bottom:0;border-left:4px solid var(--info);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(59,130,246,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--info);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Pendapatan Bulan Ini</div>
                <div style="font-size:16px;font-weight:700;color:var(--info);">
                    Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS CARDS ROW 2: Master Data ===== --}}
<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:16px;margin-bottom:24px;">
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;color:var(--primary);">{{ $totalProduk }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-box me-1"></i>Produk</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;color:var(--success);">{{ $totalKategori }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-tags me-1"></i>Kategori</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;color:var(--info);">{{ $totalMember }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-users me-1"></i>Member</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;color:var(--warning);">{{ $totalHadiah }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-gift me-1"></i>Hadiah</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;color:var(--danger);">{{ $produkStokMinimal }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-exclamation-triangle me-1"></i>Stok Kritis</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;padding:16px 10px;">
        <div style="font-size:28px;font-weight:800;" style="color:#8b5cf6;">{{ $totalKasir }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:4px;"><i class="fas fa-user-tie me-1"></i>Kasir</div>
    </div>
</div>

{{-- ===== GRAFIK: 2 kolom ===== --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">

    {{-- Grafik Pendapatan 7 Hari --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h5 class="card-title" style="margin-bottom:0;">Pendapatan 7 Hari Terakhir</h5>
            <span style="font-size:12px;color:var(--text-secondary);">Total transaksi selesai</span>
        </div>
        <div style="padding:8px 0;">
            <canvas id="grafikHarian" height="100"></canvas>
        </div>
    </div>

    {{-- Donut Metode Bayar --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header">
            <h5 class="card-title" style="margin-bottom:0;">Metode Pembayaran</h5>
        </div>
        <div style="display:flex;justify-content:center;padding:8px 0;">
            <canvas id="grafikMetode" width="200" height="200"></canvas>
        </div>
        <div id="legendMetode" style="padding:0 8px 8px;"></div>
    </div>
</div>

{{-- Grafik Bulanan --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <h5 class="card-title" style="margin-bottom:0;">Pendapatan 6 Bulan Terakhir</h5>
        <span style="font-size:12px;color:var(--text-secondary);">Perbandingan bulanan</span>
    </div>
    <canvas id="grafikBulanan" height="70"></canvas>
</div>

{{-- ===== TABEL: 2 kolom ===== --}}
<div style="display:grid;grid-template-columns:3fr 2fr;gap:20px;margin-bottom:24px;">

    {{-- Transaksi Terbaru --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h5 class="card-title" style="margin-bottom:0;">Transaksi Terbaru</h5>
            <a href="{{ route('admin.transaksi.index') }}" style="font-size:12px;color:var(--primary);">Lihat Semua →</a>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Kasir</th>
                        <th>Member</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td><code style="font-size:11px;">{{ $t->no_transaksi }}</code></td>
                        <td>{{ $t->kasir?->name ?? '-' }}</td>
                        <td>{{ $t->member?->name ?? 'Umum' }}</td>
                        <td style="font-weight:600;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge" style="background:{{ $t->metode_bayar === 'tunai' ? 'var(--success)' : 'var(--info)' }};color:#fff;font-size:10px;">
                                {{ ucfirst($t->metode_bayar ?? '-') }}
                            </span>
                        </td>
                        <td style="font-size:12px;color:var(--text-secondary);">{{ $t->dibuat_pada?->format('d/m H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Produk Stok Rendah --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h5 class="card-title" style="margin-bottom:0;">
                <i class="fas fa-exclamation-triangle me-1" style="color:var(--danger);"></i>
                Stok Kritis
            </h5>
            <a href="{{ route('admin.produk.index') }}" style="font-size:12px;color:var(--primary);">Kelola →</a>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Min</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkStokRendah as $p)
                    <tr>
                        <td>
                            <div style="font-weight:500;font-size:13px;">{{ $p->nama }}</div>
                            <div style="font-size:11px;color:var(--text-secondary);">{{ $p->kategori?->nama }}</div>
                        </td>
                        <td>
                            <span class="badge bg-danger" style="font-size:12px;">{{ $p->stok }}</span>
                        </td>
                        <td style="color:var(--text-secondary);">{{ $p->stok_minimum }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">✅ Semua stok aman</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Quick Menu --}}
        <div class="card-header" style="margin-top:16px;">
            <h5 class="card-title" style="margin-bottom:0;">Menu Cepat</h5>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;padding:12px 0 4px;">
            <a href="{{ route('admin.produk.index') }}" class="btn-menu-quick">
                <i class="fas fa-box"></i><span>Produk</span>
            </a>
            <a href="{{ route('admin.kategori-produk.index') }}" class="btn-menu-quick">
                <i class="fas fa-tags"></i><span>Kategori</span>
            </a>
            <a href="{{ route('admin.member.index') }}" class="btn-menu-quick">
                <i class="fas fa-users"></i><span>Member</span>
            </a>
            <a href="{{ route('admin.hadiah.index') }}" class="btn-menu-quick">
                <i class="fas fa-gift"></i><span>Hadiah</span>
            </a>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-menu-quick">
                <i class="fas fa-file-alt"></i><span>Transaksi</span>
            </a>
            <a href="{{ route('admin.laporan-penjualan.index') }}" class="btn-menu-quick">
                <i class="fas fa-chart-bar"></i><span>Laporan</span>
            </a>
        </div>
    </div>
</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labelHarian   = @json($grafikHarian->pluck('label'));
const dataHarian    = @json($grafikHarian->pluck('pendapatan'));
const jumlahHarian  = @json($grafikHarian->pluck('jumlah'));

const labelBulanan  = @json($grafikBulanan->pluck('label'));
const dataBulanan   = @json($grafikBulanan->pluck('pendapatan'));
const jumlahBulanan = @json($grafikBulanan->pluck('jumlah'));

const metodeLabels  = @json($metodeBayar->pluck('metode_bayar'));
const metodeData    = @json($metodeBayar->pluck('jumlah'));

// ----- Grafik Harian (Bar + Line) -----
new Chart(document.getElementById('grafikHarian'), {
    type: 'bar',
    data: {
        labels: labelHarian,
        datasets: [
            {
                label: 'Pendapatan (Rp)',
                data: dataHarian,
                backgroundColor: 'rgba(47,50,145,0.15)',
                borderColor: 'rgba(47,50,145,0.8)',
                borderWidth: 2,
                borderRadius: 6,
                yAxisID: 'y',
            },
            {
                label: 'Jumlah Transaksi',
                data: jumlahHarian,
                type: 'line',
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                borderWidth: 2,
                pointRadius: 4,
                fill: false,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'top', labels: { font: { size: 12 } } } },
        scales: {
            y:  { type: 'linear', position: 'left',  ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' } },
            y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { stepSize: 1 } },
        }
    }
});

// ----- Grafik Bulanan -----
new Chart(document.getElementById('grafikBulanan'), {
    type: 'bar',
    data: {
        labels: labelBulanan,
        datasets: [
            {
                label: 'Pendapatan (Rp)',
                data: dataBulanan,
                backgroundColor: [
                    'rgba(47,50,145,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)',
                    'rgba(245,158,11,0.7)','rgba(239,68,68,0.7)','rgba(139,92,246,0.7)'
                ],
                borderRadius: 8,
                yAxisID: 'y',
            },
            {
                label: 'Jumlah Transaksi',
                data: jumlahBulanan,
                type: 'line',
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245,158,11,0.1)',
                borderWidth: 2,
                pointRadius: 5,
                fill: false,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'top' } },
        scales: {
            y:  { type: 'linear', position: 'left',  ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' } },
            y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { stepSize: 1 } },
        }
    }
});

// ----- Donut Metode Bayar -----
const colors = ['#2f3291','#10b981','#f59e0b','#ef4444','#3b82f6'];
new Chart(document.getElementById('grafikMetode'), {
    type: 'doughnut',
    data: {
        labels: metodeLabels.map(l => l ? l.charAt(0).toUpperCase() + l.slice(1) : 'Lainnya'),
        datasets: [{
            data: metodeData,
            backgroundColor: colors.slice(0, metodeData.length),
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' transaksi' } }
        },
        cutout: '65%'
    }
});

// Custom legend
const legendEl = document.getElementById('legendMetode');
metodeLabels.forEach((l, i) => {
    legendEl.innerHTML += `<div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;font-size:12px;">
        <span style="width:10px;height:10px;border-radius:50%;background:${colors[i]};display:inline-block;"></span>
        ${l ? l.charAt(0).toUpperCase() + l.slice(1) : 'Lainnya'}: <b>${metodeData[i]}</b>
    </div>`;
});
</script>

<style>
.btn-menu-quick {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 14px 8px;
    border-radius: 10px;
    background: var(--bg-body);
    text-decoration: none;
    color: var(--text-main);
    font-size: 12px;
    font-weight: 600;
    transition: var(--transition);
    text-align: center;
}
.btn-menu-quick:hover {
    background: var(--primary);
    color: #fff;
}
.btn-menu-quick i {
    font-size: 20px;
    color: var(--primary);
}
.btn-menu-quick:hover i { color: #fff; }
</style>
@endsection
