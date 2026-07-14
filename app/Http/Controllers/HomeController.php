<?php

namespace App\Http\Controllers;

use App\Models\Data\Transaksi;
use App\Models\Master\Hadiah;
use App\Models\Master\KategoriProduk;
use App\Models\Master\Produk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'kasir'  => redirect()->route('kasir.dashboard'),
            'member' => redirect()->route('member.dashboard'),
            default  => redirect()->route('login'),
        };
    }

    public function adminDashboard(): View
    {
        // === STATS CARDS ===
        $totalProduk      = Produk::count();
        $totalKategori    = KategoriProduk::count();
        $totalMember      = User::member()->count();
        $produkStokMinimal = Produk::stokMinimal()->count();
        $totalHadiah      = Hadiah::count();
        $totalKasir       = User::kasir()->count();

        // === TRANSAKSI SUMMARY ===
        $transaksiHariIni   = Transaksi::whereDate('dibuat_pada', today())->where('status', 'selesai')->count();
        $pendapatanHariIni  = Transaksi::whereDate('dibuat_pada', today())->where('status', 'selesai')->sum('total_harga');
        $transaksibulanIni  = Transaksi::whereMonth('dibuat_pada', now()->month)->whereYear('dibuat_pada', now()->year)->where('status', 'selesai')->count();
        $pendapatanBulanIni = Transaksi::whereMonth('dibuat_pada', now()->month)->whereYear('dibuat_pada', now()->year)->where('status', 'selesai')->sum('total_harga');

        // === GRAFIK: Pendapatan 7 hari terakhir ===
        $grafikHarian = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $grafikHarian->push([
                'label'      => $tgl->format('d M'),
                'pendapatan' => (float) Transaksi::whereDate('dibuat_pada', $tgl)->where('status', 'selesai')->sum('total_harga'),
                'jumlah'     => Transaksi::whereDate('dibuat_pada', $tgl)->where('status', 'selesai')->count(),
            ]);
        }

        // === GRAFIK: Pendapatan 6 bulan terakhir ===
        $grafikBulanan = collect();
        for ($i = 5; $i >= 0; $i--) {
            $bln = Carbon::now()->startOfMonth()->subMonths($i);
            $grafikBulanan->push([
                'label'      => $bln->format('M Y'),
                'pendapatan' => (float) Transaksi::whereMonth('dibuat_pada', $bln->month)->whereYear('dibuat_pada', $bln->year)->where('status', 'selesai')->sum('total_harga'),
                'jumlah'     => Transaksi::whereMonth('dibuat_pada', $bln->month)->whereYear('dibuat_pada', $bln->year)->where('status', 'selesai')->count(),
            ]);
        }

        // === Metode Bayar Distribusi ===
        $metodeBayar = Transaksi::where('status', 'selesai')
            ->selectRaw('metode_bayar, COUNT(*) as jumlah, SUM(total_harga) as total')
            ->groupBy('metode_bayar')
            ->get();

        // === Produk stok rendah ===
        $produkStokRendah = Produk::with('kategori')->stokMinimal()->latest()->take(5)->get();

        // === Transaksi terbaru ===
        $transaksiTerbaru = Transaksi::with(['kasir', 'member'])
            ->where('status', 'selesai')
            ->latest('dibuat_pada')
            ->take(8)
            ->get();

        return view('home.admin', compact(
            'totalProduk', 'totalKategori', 'totalMember', 'produkStokMinimal',
            'totalHadiah', 'totalKasir',
            'transaksiHariIni', 'pendapatanHariIni',
            'transaksibulanIni', 'pendapatanBulanIni',
            'grafikHarian', 'grafikBulanan',
            'metodeBayar', 'produkStokRendah', 'transaksiTerbaru'
        ));
    }

    public function adminSettings(): View
    {
        return view('home.admin-settings');
    }

    /**
     * Dashboard Kasir - DIPERBAIKI
     * Sekarang menampilkan data SEMUA transaksi seperti admin
     */
    public function kasirDashboard(): View
    {
        $kasir = auth()->user();

        // === STATS KASIR - MENAMPILKAN DATA SEMUA TRANSAKSI ===
        // PERBAIKAN: Menghapus filter ->where('id_kasir', $kasir->id)
        $transaksiHariIni      = Transaksi::whereDate('dibuat_pada', today())->where('status', 'selesai')->count();
        $pendapatanHariIni     = Transaksi::whereDate('dibuat_pada', today())->where('status', 'selesai')->sum('total_harga');
        $transaksiMingguIni    = Transaksi::whereBetween('dibuat_pada', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'selesai')->count();
        $pendapatanMingguIni   = Transaksi::whereBetween('dibuat_pada', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'selesai')->sum('total_harga');
        $totalTransaksiKasir   = Transaksi::where('status', 'selesai')->count();
        $produkTersedia        = Produk::aktif()->count();

        // === GRAFIK: Transaksi 7 hari terakhir - SEMUA KASIR ===
        // PERBAIKAN: Menghapus filter ->where('id_kasir', $kasir->id)
        $grafikKasir = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $grafikKasir->push([
                'label'      => $tgl->format('d M'),
                'pendapatan' => (float) Transaksi::whereDate('dibuat_pada', $tgl)->where('status', 'selesai')->sum('total_harga'),
                'jumlah'     => Transaksi::whereDate('dibuat_pada', $tgl)->where('status', 'selesai')->count(),
            ]);
        }

        // === Metode Bayar - SEMUA TRANSAKSI ===
        // PERBAIKAN: Menghapus filter ->where('id_kasir', $kasir->id)
        $metodeBayarKasir = Transaksi::where('status', 'selesai')
            ->selectRaw('metode_bayar, COUNT(*) as jumlah')
            ->groupBy('metode_bayar')
            ->get();

        // === Transaksi terbaru - SEMUA KASIR ===
        // PERBAIKAN: Menghapus filter ->where('id_kasir', $kasir->id)
        $transaksiTerbaru = Transaksi::with(['kasir', 'member'])
            ->where('status', 'selesai')
            ->latest('dibuat_pada')
            ->take(8)
            ->get();

        return view('home.kasir', compact(
            'kasir',
            'transaksiHariIni', 'pendapatanHariIni',
            'transaksiMingguIni', 'pendapatanMingguIni',
            'totalTransaksiKasir', 'produkTersedia',
            'grafikKasir', 'metodeBayarKasir', 'transaksiTerbaru'
        ));
    }

    public function memberDashboard(): View
    {
        $user = auth()->user();

        $riwayatPoin = $user->riwayatPoin()
            ->latest('dibuat_pada')
            ->take(5)
            ->get();

        return view('home.member', compact('user', 'riwayatPoin'));
    }
}