<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware opsional — mencatat aksi view (GET ke halaman show/detail).
 * Middleware CRUD sudah ditangani lewat trait HasActivityLog di model.
 *
 * Cara daftar (di app/Http/Kernel.php):
 *   protected $middlewareGroups = [
 *       'web' => [
 *           ...
 *           \App\Http\Middleware\LogActivity::class,
 *       ],
 *   ];
 */
class LogActivity
{
    /**
     * Pola URL yang akan dicatat sebagai aksi "view".
     * Format: [regex_pattern => module_name]
     */
    protected array $viewPatterns = [
        '/admin\/produk\/\d+$/'     => 'Produk',
        '/admin\/user\/\d+$/'       => 'User',
        '/admin\/transaksi\/\d+$/'  => 'Transaksi',
        '/admin\/member\/\d+$/'     => 'Member',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat GET request oleh user yang sudah login
        if ($request->isMethod('GET') && auth()->check()) {
            $this->maybeLogView($request);
        }

        return $response;
    }

    private function maybeLogView(Request $request): void
    {
        $path = $request->path();

        foreach ($this->viewPatterns as $pattern => $module) {
            if (preg_match($pattern, $path)) {
                \App\Services\ActivityLogger::log(
                    action:      'view',
                    module:      $module,
                    description: "Melihat detail {$module}",
                );
                break;
            }
        }
    }
}
