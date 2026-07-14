<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MemberLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Tampilkan halaman login khusus member.
     */
    public function showLoginForm(): View
    {
        return view('auth.login-member');
    }

    /**
     * Proses login member menggunakan no_telepon + password.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'no_telepon' => 'required|string',
            'password'   => 'required|string',
        ], [
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'password.required'   => 'Kata sandi wajib diisi.',
        ]);

        $credentials = [
            'no_telepon' => $request->no_telepon,
            'password'   => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Pastikan yang login adalah member, bukan admin/kasir
            if (!$user->isMember()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'no_telepon' => 'Akun ini bukan akun member. Silakan gunakan halaman login pegawai.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('member.dashboard'));
        }

        throw ValidationException::withMessages([
            'no_telepon' => 'Nomor telepon atau kata sandi salah.',
        ]);
    }

    /**
     * Logout member dan redirect ke halaman login member.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('member.login');
    }
}