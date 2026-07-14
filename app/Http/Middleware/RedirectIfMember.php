<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: RedirectIfMember
 *
 * Digunakan pada route area member.
 * Jika user belum login → redirect ke /loginmember (bukan /login default).
 * Jika sudah login tapi bukan member → abort 403.
 *
 * Cara daftar di app/Http/Kernel.php pada $routeMiddleware:
 *   'member.auth' => \App\Http\Middleware\RedirectIfMember::class,
 *
 * Cara pakai di route (opsional, sebagai pengganti 'auth' + 'role:member'):
 *   ->middleware('member.auth')
 */
class RedirectIfMember
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login → arahkan ke halaman login member
        if (!Auth::check()) {
            return redirect()->route('member.login')
                ->with('info', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        // Sudah login tapi bukan member → tolak
        if (!Auth::user()->isMember()) {
            abort(403, 'Halaman ini hanya untuk member koperasi.');
        }

        return $next($request);
    }
}