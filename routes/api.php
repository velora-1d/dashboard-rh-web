<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BendaharaController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Bendahara Routes
    Route::prefix('bendahara')->group(function () {
        Route::get('/dashboard', [BendaharaController::class, 'dashboard']);
        Route::get('/cek-tunggakan', [BendaharaController::class, 'cekTunggakan']);
    });

    // Perizinan Routes (Wali Santri)
    Route::get('/perizinan', [\App\Http\Controllers\Api\PerizinanController::class, 'index']);
    Route::post('/perizinan', [\App\Http\Controllers\Api\PerizinanController::class, 'store']);

    // Hafalan Routes (Wali Santri & Pendidikan)
    Route::get('/hafalan', [\App\Http\Controllers\Api\HafalanController::class, 'index']);
    Route::post('/hafalan', [\App\Http\Controllers\Api\HafalanController::class, 'store']); // Input by Pendidikan

});
