<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Resolve route name berdasarkan role user yang sedang login.
     */
    private function settingsRoute(string $name): string
    {
        $role = Auth::user()->role; // 'admin' atau 'kasir'
        return "{$role}.settings.{$name}";
    }

    /**
     * Tampilkan halaman pengaturan.
     */
    public function index()
    {
        return view('home.settings');
    }

    /**
     * Update profil (nama, username, email).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'telepon' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'username.required'   => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-) dan garis bawah (_).',
            'username.unique'     => 'Username sudah digunakan, silakan pilih yang lain.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah terdaftar.',
        ]);

        $user->update($validated);

        return redirect()
            ->route($this->settingsRoute('index'))
            ->with('success_profile', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->withInput()
                ->with('active_tab', 'keamanan');
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()
                ->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password saat ini.'])
                ->withInput()
                ->with('active_tab', 'keamanan');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route($this->settingsRoute('index'))
            ->with('success_password', 'Password berhasil diperbarui.')
            ->with('active_tab', 'keamanan');
    }
}