<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QzController extends Controller
{
    /**
     * Kirim isi digital-certificate.txt ke browser
     */
    public function certificate()
    {
        $path = config('qz.certificate_path');

        if (!File::exists($path)) {
            abort(404, 'Certificate belum digenerate');
        }

        return response(File::get($path), 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Sign request dari QZ Tray menggunakan private key
     */
    public function sign(Request $request)
    {
        $request->validate([
            'request' => 'required|string',
        ]);

        $privateKeyPath = config('qz.private_key_path');

        if (!File::exists($privateKeyPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Private key tidak ditemukan di server',
            ], 500);
        }

        $privateKeyPem = File::get($privateKeyPath);
        $privateKey    = openssl_pkey_get_private($privateKeyPem);

        if ($privateKey === false) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal load private key: ' . openssl_error_string(),
            ], 500);
        }

        $signature = '';
        $ok = openssl_sign($request->input('request'), $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$ok) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal sign request: ' . openssl_error_string(),
            ], 500);
        }

        return response(base64_encode($signature), 200)
            ->header('Content-Type', 'text/plain');
    }
}