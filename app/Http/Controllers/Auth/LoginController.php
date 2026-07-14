<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ], [
            'identifier.required' => 'Username atau email wajib diisi.',
            'password.required'   => 'Kata sandi wajib diisi.',
        ]);

        $identifier = $request->identifier;
        $password   = $request->password;
        $remember   = $request->boolean('remember');

        // 1. Coba login via username (admin & kasir)
        if ($this->attemptLogin(['username' => $identifier, 'password' => $password], $remember)) {
            $user = Auth::user();
            if ($user->isMember()) {
                Auth::logout();
            } else {
                $request->session()->regenerate();
                ActivityLogger::login();
                return $this->redirectAfterLogin($user->role);
            }
        }

        // 2. Coba login via email (admin & kasir)
        if ($this->attemptLogin(['email' => $identifier, 'password' => $password], $remember)) {
            $user = Auth::user();
            if ($user->isMember()) {
                Auth::logout();
            } else {
                $request->session()->regenerate();
                ActivityLogger::login();
                return $this->redirectAfterLogin($user->role);
            }
        }

        // 3. Coba login via no_telepon (member)
        if ($this->attemptLogin(['no_telepon' => $identifier, 'password' => $password], $remember)) {
            $user = Auth::user();
            if (!$user->isMember()) {
                Auth::logout();
            } else {
                $request->session()->regenerate();
                ActivityLogger::login();
                return $this->redirectAfterLogin($user->role);
            }
        }

        throw ValidationException::withMessages([
            'identifier' => 'Username atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        ActivityLogger::logout();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function attemptLogin(array $credentials, bool $remember): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    private function redirectAfterLogin(string $role): RedirectResponse
    {
        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'kasir'  => redirect()->route('kasir.dashboard'),
            'member' => redirect()->route('member.dashboard'),
            default  => redirect()->route('home'),
        };
    }
}