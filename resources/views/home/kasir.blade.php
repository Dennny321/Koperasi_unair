@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('breadcrumb', 'Pages / Kasir / Dashboard')
@section('page-title', 'Dashboard Kasir')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="content-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div>
        <h2 style="color:var(--primary);font-size:26px;margin-bottom:4px;">
            Selamat Datang, {{ $kasir->name }}! 👋
        </h2>
        <p style="color:var(--text-secondary);">Dashboard Kasir — Koperasi Pegawai UNAIR</p>
    </div>
    <div style="font-size:13px;color:var(--text-secondary);">
        <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d F Y, H:i') }}
    </div>
</div>

{{-- ===== STATS CARDS ===== --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px;">

    <div class="card" style="margin-bottom:0;border-left:4px solid var(--primary);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(47,50,145,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--primary);">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Transaksi Hari Ini</div>
                <div style="font-size:30px;font-weight:800;color:var(--primary);">{{ $transaksiHariIni }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:0;border-left:4px solid var(--success);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(16,185,129,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--success);">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Pendapatan Hari Ini</div>
                <div style="font-size:20px;font-weight:700;color:var(--success);">
                    Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:0;border-left:4px solid var(--warning);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(245,158,11,0.1);
                        display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--warning);">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-secondary);font-weight:500;">Pendapatan Minggu Ini</div>
                <div style="font-size:20px;font-weight:700;color:var(--warning);">
                    Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">
    <div class="card" style="margin-bottom:0;text-align:center;">
        <div style="font-size:30px;font-weight:800;color:var(--info);">{{ $transaksiMingguIni }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:2px;"><i class="fas fa-calendar-week me-1"></i>Transaksi Minggu Ini</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;">
        <div style="font-size:30px;font-weight:800;" style="color:#8b5cf6;">{{ $totalTransaksiKasir }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:2px;"><i class="fas fa-history me-1"></i>Total Seluruh Transaksi</div>
    </div>
    <div class="card" style="margin-bottom:0;text-align:center;">
        <div style="font-size:30px;font-weight:800;color:var(--success);">{{ $produkTersedia }}</div>
        <div style="font-size:12px;color:var(--text-secondary);margin-top:2px;"><i class="fas fa-box me-1"></i>Produk Tersedia</div>
    </div>
</div>

{{-- ===== GRAFIK + DONUT ===== --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">

    {{-- Grafik Transaksi 7 Hari --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h5 class="card-title" style="margin-bottom:0;">Performansi 7 Hari Terakhir</h5>
            <span style="font-size:12px;color:var(--text-secondary);">Transaksi saya</span>
        </div>
        <div style="padding:8px 0;">
            <canvas id="grafikKasir" height="110"></canvas>
        </div>
    </div>

    {{-- Metode Bayar + Aksi Cepat --}}
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="card" style="margin-bottom:0;flex:1;">
            <div class="card-header">
                <h5 class="card-title" style="margin-bottom:0;">Metode Bayar</h5>
            </div>
            <div style="display:flex;justify-content:center;padding:8px 0;">
                <canvas id="grafikMetodeKasir" width="160" height="160"></canvas>
            </div>
            <div id="legendMetodeKasir" style="padding:0 8px 8px;"></div>
        </div>
    </div>
</div>

{{-- ===== TABEL + MENU CEPAT ===== --}}
<div style="display:grid;grid-template-columns:3fr 1fr;gap:20px;margin-bottom:24px;">

    {{-- Transaksi Terbaru --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h5 class="card-title" style="margin-bottom:0;">Transaksi Terbaru Saya</h5>
            <a href="{{ route('kasir.transaksi.index') }}" style="font-size:12px;color:var(--primary);">Lihat Semua →</a>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Transaksi</th>
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
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada transaksi hari ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Menu Cepat --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header">
            <h5 class="card-title" style="margin-bottom:0;">Menu Kasir</h5>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;padding:4px 0;">
            <a href="{{ route('kasir.transaksi.create') }}" class="btn-kasir-menu" style="background:var(--primary);color:#fff;">
                <i class="fas fa-cash-register" style="font-size:20px;"></i>
                <span>Transaksi Baru</span>
            </a>
            <a href="{{ route('kasir.transaksi.index') }}" class="btn-kasir-menu">
                <i class="fas fa-list-alt" style="font-size:18px;color:var(--primary);"></i>
                <span>Daftar Transaksi</span>
            </a>
            <a href="{{ route('kasir.laporan-penjualan.index') }}" class="btn-kasir-menu">
                <i class="fas fa-chart-bar" style="font-size:18px;color:var(--success);"></i>
                <span>Laporan Penjualan</span>
            </a>
            <a href="{{ route('kasir.surat-jalan.index') }}" class="btn-kasir-menu">
                <i class="fas fa-file-alt" style="font-size:18px;color:var(--info);"></i>
                <span>Surat Jalan</span>
            </a>
          
            <a href="{{ route('kasir.member.index') }}" class="btn-kasir-menu">
                <i class="fas fa-users" style="font-size:18px;" style="color:#8b5cf6;"></i>
                <span>Lihat Member</span>
            </a>
        </div>
    </div>
</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labelKasir    = @json($grafikKasir->pluck('label'));
const dataKasir     = @json($grafikKasir->pluck('pendapatan'));
const jumlahKasir   = @json($grafikKasir->pluck('jumlah'));
const metodeLabels  = @json($metodeBayarKasir->pluck('metode_bayar'));
const metodeData    = @json($metodeBayarKasir->pluck('jumlah'));
const colors = ['#2f3291','#10b981','#f59e0b','#ef4444','#3b82f6'];

// ----- Grafik Kasir -----
new Chart(document.getElementById('grafikKasir'), {
    type: 'bar',
    data: {
        labels: labelKasir,
        datasets: [
            {
                label: 'Pendapatan (Rp)',
                data: dataKasir,
                backgroundColor: 'rgba(47,50,145,0.15)',
                borderColor: 'rgba(47,50,145,0.8)',
                borderWidth: 2,
                borderRadius: 6,
                yAxisID: 'y',
            },
            {
                label: 'Jumlah Transaksi',
                data: jumlahKasir,
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

// ----- Donut Metode Bayar Kasir -----
new Chart(document.getElementById('grafikMetodeKasir'), {
    type: 'doughnut',
    data: {
        labels: metodeLabels.map(l => l ? l.charAt(0).toUpperCase() + l.slice(1) : 'Lainnya'),
        datasets: [{
            data: metodeData.length ? metodeData : [1],
            backgroundColor: metodeData.length ? colors.slice(0, metodeData.length) : ['#e2e8f0'],
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
        cutout: '60%'
    }
});

// Custom legend
const legendEl = document.getElementById('legendMetodeKasir');
if (metodeLabels.length === 0) {
    legendEl.innerHTML = '<p style="font-size:12px;color:#aaa;text-align:center;">Belum ada data</p>';
} else {
    metodeLabels.forEach((l, i) => {
        legendEl.innerHTML += `<div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;font-size:12px;">
            <span style="width:10px;height:10px;border-radius:50%;background:${colors[i]};display:inline-block;"></span>
            ${l ? l.charAt(0).toUpperCase() + l.slice(1) : 'Lainnya'}: <b>${metodeData[i]}</b>
        </div>`;
    });
}
</script>

<style>
.btn-kasir-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 10px;
    background: var(--bg-body);
    text-decoration: none;
    color: var(--text-main);
    font-size: 13px;
    font-weight: 600;
    transition: var(--transition);
}
.btn-kasir-menu:hover {
    background: var(--primary);
    color: #fff;
    transform: translateX(4px);
}
.btn-kasir-menu:hover i { color: #fff !important; }
</style>
@endsection
