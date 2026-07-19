<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PrintJobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/print-jobs', [PrintJobController::class, 'push']);
    Route::get('/print-jobs/{id}/status', [PrintJobController::class, 'status']);
});

// Dipanggil Python agent (pakai token, tidak butuh session)
Route::post('/print-jobs/{id}/result', [PrintJobController::class, 'result']);
Route::get('/print-jobs/poll', [PrintJobController::class, 'poll']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
