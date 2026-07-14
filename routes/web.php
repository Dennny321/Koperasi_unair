<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MemberLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Data\LaporanPenjualanController;
use App\Http\Controllers\Data\SuratJalanController;
use App\Http\Controllers\Data\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\HadiahController;
use App\Http\Controllers\Master\KategoriProdukController;
use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\ProdukController;
use App\Http\Controllers\Master\RestockController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\PenukaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Auth Routes — Pegawai (Admin & Kasir)
|--------------------------------------------------------------------------
*/


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Auth Routes — Member
|--------------------------------------------------------------------------
*/


Route::get('/loginmember', [MemberLoginController::class, 'showLoginForm'])
    ->name('member.login')
    ->middleware('guest');


Route::post('/loginmember', [MemberLoginController::class, 'login'])
    ->name('member.login.post')
    ->middleware('guest');


Route::post('/member/logout', [MemberLoginController::class, 'logout'])
    ->name('member.logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| Registrasi Member
|--------------------------------------------------------------------------
*/


Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/daftar', [RegisterController::class, 'register'])->name('register.post')->middleware('guest');


/*
|--------------------------------------------------------------------------
| Redirect /home
|--------------------------------------------------------------------------
*/


Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Dashboard per role
|--------------------------------------------------------------------------
*/


Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);


Route::get('/kasir/dashboard', [HomeController::class, 'kasirDashboard'])
    ->name('kasir.dashboard')
    ->middleware(['auth', 'role:kasir']);


Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
    ->name('member.dashboard')
    ->middleware(['auth', 'role:member']);


/*
|--------------------------------------------------------------------------
| Admin — akses penuh ke semua master data
|--------------------------------------------------------------------------
*/




Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/',         [SettingsController::class, 'index'])->name('index');
        Route::put('/profil',   [SettingsController::class, 'updateProfile'])->name('profile');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password');
    });

    Route::prefix('activity-log')->name('activity-log.')->group(function () {
        Route::get('/',              [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('show');
        Route::delete('/purge-old',  [ActivityLogController::class, 'purgeOld'])->name('purge-old');
    });


    // Laporan Penjualan
    Route::get('laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan.index');
    Route::get('laporan-penjualan/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('laporan-penjualan.excel');
    Route::get('laporan-penjualan/pdf', [LaporanPenjualanController::class, 'cetakPdf'])->name('laporan-penjualan.pdf');


    // Master Data Resources
    Route::resource('user', UserController::class);
    Route::get('user/check-duplicate',         [UserController::class, 'checkDuplicate'])->name('user.check-duplicate');
    Route::resource('produk', ProdukController::class);
    Route::resource('supplier', SupplierController::class);


    // Restock Routes - PENTING: Taruh route custom SEBELUM resource!
    Route::post('restock/{restock}/approve', [RestockController::class, 'approve'])->name('restock.approve');
    Route::post('restock/{restock}/cancel', [RestockController::class, 'cancel'])->name('restock.cancel');
    Route::get('restock/export/excel', [\App\Http\Controllers\Master\RestockController::class, 'exportExcel'])
        ->name('restock.export.excel');

    Route::get('restock/export/pdf',   [\App\Http\Controllers\Master\RestockController::class, 'exportPdf'])
        ->name('restock.export.pdf');
    Route::resource('restock', RestockController::class);


    Route::resource('kategori-produk', KategoriProdukController::class);
    Route::resource('member', MemberController::class);


    // AJAX Endpoints (Opsional - untuk select2/autocomplete)
    Route::get('supplier/ajax/get', [SupplierController::class, 'getSuppliers'])->name('supplier.getSuppliers');
    Route::get('restock/ajax/produks', [RestockController::class, 'getProduks'])->name('restock.getProduks');




    // ---- HADIAH ----
    Route::get('hadiah/{hadiah}/kode', [HadiahController::class, 'kodeIndex'])
        ->name('hadiah.kode.index');
    Route::post('hadiah/{hadiah}/kode/generate', [HadiahController::class, 'kodeGenerate'])
        ->name('hadiah.kode.generate');
    Route::delete('hadiah/{hadiah}/kode/{kode}', [HadiahController::class, 'kodeDestroy'])
        ->name('hadiah.kode.destroy');
    Route::delete('hadiah/{hadiah}/kode', [HadiahController::class, 'kodeDestroyAll'])
        ->name('hadiah.kode.destroy-all');


    Route::resource('hadiah', HadiahController::class);


    Route::post('hadiah-penukaran/{penukaran}/klaim', [HadiahController::class, 'klaimPenukaran'])
        ->name('hadiah.klaim');
    Route::post('hadiah-penukaran/{penukaran}/batal', [HadiahController::class, 'batalPenukaran'])
        ->name('hadiah.batal');


    // ---- TRANSAKSI ----
    // PENTING: route statis harus SEBELUM Route::resource agar tidak bentrok dengan {transaksi}
    Route::get('transaksi/cari-produk', [TransaksiController::class, 'cariProduk'])
        ->name('transaksi.cari-produk');
    Route::get('transaksi/cari-member', [TransaksiController::class, 'cariMember'])
        ->name('transaksi.cari-member');
    Route::get('transaksi/{id}/nota', [TransaksiController::class, 'cetakNota'])
        ->name('transaksi.nota');


    // ESC/POS — cetak langsung ke printer USB/Network
    Route::post('transaksi/{id}/print-escpos', [TransaksiController::class, 'printEscpos'])
        ->name('transaksi.print-escpos');


    Route::resource('transaksi', TransaksiController::class);


    // ---- SURAT JALAN ----
    Route::get('surat-jalan/cari-produk', [SuratJalanController::class, 'cariProduk'])
        ->name('surat-jalan.cari-produk');
    Route::get('surat-jalan/{id}/cetak', [SuratJalanController::class, 'cetak'])
        ->name('surat-jalan.cetak');
    Route::resource('surat-jalan', SuratJalanController::class);
});


/*
|--------------------------------------------------------------------------
| Kasir — satu group, tidak ada duplikasi
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:admin,kasir'])->prefix('kasir')->name('kasir.')->group(function () {


    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/',         [SettingsController::class, 'index'])->name('index');
        Route::put('/profil',   [SettingsController::class, 'updateProfile'])->name('profile');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password');
    });


    // Produk (read only)
    Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');


    // Member — CRUD penuh
    Route::resource('member', MemberController::class);


    // Laporan Penjualan
    Route::get('laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan.index');
    Route::get('laporan-penjualan/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('laporan-penjualan.excel');
    Route::get('laporan-penjualan/pdf', [LaporanPenjualanController::class, 'cetakPdf'])->name('laporan-penjualan.pdf');


    // ---- TRANSAKSI ----
    // PENTING: route statis harus SEBELUM Route::resource
    Route::get('transaksi/cari-produk', [TransaksiController::class, 'cariProduk'])
        ->name('transaksi.cari-produk');
    Route::get('transaksi/cari-member', [TransaksiController::class, 'cariMember'])
        ->name('transaksi.cari-member');
    Route::get('transaksi/{id}/nota', [TransaksiController::class, 'cetakNota'])
        ->name('transaksi.nota');


    // ESC/POS — cetak langsung ke printer USB/Network
    Route::post('transaksi/{id}/print-escpos', [TransaksiController::class, 'printEscpos'])
        ->name('transaksi.print-escpos');


    Route::resource('transaksi', TransaksiController::class);


    // ---- SURAT JALAN ----
    Route::get('surat-jalan/cari-produk', [SuratJalanController::class, 'cariProduk'])
        ->name('surat-jalan.cari-produk');
    Route::get('surat-jalan/{id}/cetak', [SuratJalanController::class, 'cetak'])
        ->name('surat-jalan.cetak');
    Route::resource('surat-jalan', SuratJalanController::class);
});


/*
|--------------------------------------------------------------------------
| Member — akses eksklusif area member
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::resource('penukaran', PenukaranController::class)->only(['index', 'store', 'destroy']);


    Route::get('riwayat-poin', [MemberDashboardController::class, 'riwayatPoin'])
        ->name('riwayat-poin');


    Route::get('riwayat-transaksi', [MemberDashboardController::class, 'riwayatTransaksi'])
        ->name('riwayat-transaksi');


    Route::get('profil', [MemberDashboardController::class, 'profil'])
        ->name('profil');


    Route::put('profil/update-profile', [MemberDashboardController::class, 'updateProfile'])
        ->name('profil.update-profile');

    Route::put('profil/update-password', [MemberDashboardController::class, 'updatePassword'])
        ->name('profil.update-password');
});
