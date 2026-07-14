<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Master\Hadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:member']);
    }

    /**
     * Dashboard utama member.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Statistik poin
        $totalPoinMasuk = $user->riwayatPoin()
            ->masuk()
            ->sum('poin');

        $totalPoinKeluar = $user->riwayatPoin()
            ->keluar()
            ->sum('poin');

        // Riwayat poin terbaru (5 terakhir)
        $riwayatPoin = $user->riwayatPoin()
            ->latest('dibuat_pada')
            ->take(5)
            ->get();

        // Transaksi terbaru (5 terakhir)
        $transaksiTerbaru = $user->transaksiSebagaiMember()
            ->latest('dibuat_pada')
            ->take(5)
            ->get();

        // Total transaksi member
        $totalTransaksi = $user->transaksiSebagaiMember()->count();

        // Hadiah yang bisa ditukar (tersedia & poin cukup)
        $hadiahTersedia = Hadiah::tersedia()
            ->orderBy('biaya_poin')
            ->take(4)
            ->get();

        // Penukaran yang sedang menunggu
        $penukaranMenunggu = $user->penukaran()
            ->menunggu()
            ->with('hadiah')
            ->latest('dibuat_pada')
            ->take(3)
            ->get();

        return view('home.member', compact(
            'user',
            'totalPoinMasuk',
            'totalPoinKeluar',
            'riwayatPoin',
            'transaksiTerbaru',
            'totalTransaksi',
            'hadiahTersedia',
            'penukaranMenunggu',
        ));
    }

    /**
     * Halaman Riwayat Poin (semua, dengan filter & pagination)
     */
    public function riwayatPoin(Request $request): View
    {
        $user = auth()->user();

        $query = $user->riwayatPoin()->latest('dibuat_pada');

        // Filter jenis
        if ($request->filled('jenis') && in_array($request->jenis, ['masuk', 'keluar'])) {
            $query->where('jenis', $request->jenis);
        }

        $riwayatPoin = $query->paginate(20);

        // Kalkulasi total poin masuk dan keluar
        $totalPoinMasuk = $user->riwayatPoin()
            ->masuk()
            ->sum('poin');

        $totalPoinKeluar = $user->riwayatPoin()
            ->keluar()
            ->sum('poin');

        return view('member.riwayat-poin', compact('user', 'riwayatPoin', 'totalPoinMasuk', 'totalPoinKeluar'));
    }

    /**
     * Halaman Riwayat Transaksi (semua, dengan pagination)
     */
    public function riwayatTransaksi(): View
    {
        $user = auth()->user();

        $transaksi = $user->transaksiSebagaiMember()
            ->latest('dibuat_pada')
            ->paginate(20);

        $totalTransaksi = $user->transaksiSebagaiMember()->count();

        // ✅ Tambahkan ini
        $totalBelanja = $user->transaksiSebagaiMember()->sum('total_harga'); // sesuaikan nama kolom

        return view('member.riwayat-transaksi', compact(
            'user',
            'transaksi',
            'totalTransaksi',
            'totalBelanja'
        ));
    }
    /**
     * Halaman Profil Saya
     */
    public function profil(): View
    {
        $user = auth()->user();

        $totalTransaksi = $user->transaksiSebagaiMember()->count();

        $totalPoinMasuk = $user->riwayatPoin()
            ->masuk()
            ->sum('poin');

        $totalPenukaran = $user->penukaran()->count(); // atau sesuai kebutuhan

        return view('member.profil', compact(
            'user',
            'totalTransaksi',
            'totalPoinMasuk',
            'totalPenukaran'
        ));
    }

    /**
     * Update Password Member
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_telepon'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'no_telepon')->ignore($user->id),
            ],
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan akun lain.',
            'no_telepon.required'   => 'Nomor telepon wajib diisi.',
            'no_telepon.unique'     => 'Nomor telepon sudah terdaftar di akun lain.',
        ]);

        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()
            ->route('member.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password member.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'Password baru tidak boleh sama dengan password saat ini.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route('member.profil')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
