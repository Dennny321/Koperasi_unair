<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PrintJobController;

// ── Dipanggil Python agent (token, tanpa session) ──────────────
Route::get('/print-jobs/poll', [PrintJobController::class, 'poll']);
Route::post('/print-jobs/{id}/result', [PrintJobController::class, 'result']);

// ── Dipanggil browser kasir (pakai session login biasa) ─────────
Route::middleware('auth')->group(function () {
    Route::post('/print-jobs', [PrintJobController::class, 'push']);
    Route::get('/print-jobs/{id}/status', [PrintJobController::class, 'status']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});