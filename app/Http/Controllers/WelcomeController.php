<?php


namespace App\Http\Controllers;


use App\Models\Master\KategoriProduk;
use App\Models\Master\Produk;
use App\Models\Master\Hadiah;
use App\Models\User;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{
   /**
    * Display the welcome/landing page.
    */
   public function index()
   {
       // Ambil data statistik
       $totalProduk = Produk::aktif()->count();
       $totalHadiah = Hadiah::aktif()->count();
       $totalMember = User::member()->count(); // Menggunakan scope member() dari User model


       // Ambil kategori produk dengan jumlah produk
       $kategoriProduk = KategoriProduk::withCount('produk')
           ->orderBy('nama', 'asc')
           ->take(8)
           ->get();


       // Ambil produk terbaru (max 8)
       $produkTerbaru = Produk::with('kategori')
           ->aktif()
           ->orderBy('created_at', 'desc')
           ->take(8)
           ->get();


       // Ambil hadiah yang tersedia (max 6)
       $hadiahTersedia = Hadiah::tersedia()
           ->orderBy('biaya_poin', 'asc')
           ->take(6)
           ->get();


       return view('welcome', compact(
           'totalProduk',
           'totalHadiah',
           'totalMember',
           'kategoriProduk',
           'produkTerbaru',
           'hadiahTersedia'
       ));
   }
}




