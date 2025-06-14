<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\UseProfilerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// RUTE PUBLIK (TIDAK PERLU LOGIN)
// =========================================================================

// Rute untuk registrasi (membuat user baru).
Route::post('/users', [UserController::class, 'store']);

// Rute untuk login
Route::post('/login', [AuthController::class, 'login']);


// =========================================================================
// RUTE TERPROTEKSI (WAJIB LOGIN)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {

    // Rute untuk mendapatkan & mengupdate data user yang sedang login
    Route::get('/user', [UseProfilerController::class, 'getProfile']);
    Route::post('/profile/update', [UseProfilerController::class, 'updateField']);
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rute lain yang butuh login (contoh)
    Route::apiResource('orders', OrderController::class)->except(['create', 'edit']);

    // Rute khusus Admin
    // ...
});