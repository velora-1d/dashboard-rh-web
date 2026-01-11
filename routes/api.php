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

    // Sekretaris Routes
    Route::prefix('sekretaris')->group(function () {
        Route::get('/santri', [\App\Http\Controllers\Api\SekretarisController::class, 'index']);
        Route::get('/perizinan', [\App\Http\Controllers\Api\SekretarisController::class, 'perizinan']);
    });

    // Bendahara Routes
    Route::prefix('bendahara')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\BendaharaController::class, 'dashboard']);
        Route::get('/kas', [\App\Http\Controllers\Api\BendaharaController::class, 'kas']);
        Route::get('/cek-tunggakan', [\App\Http\Controllers\Api\BendaharaController::class, 'cekTunggakan']);
    });

    // Pendidikan Routes
    Route::prefix('pendidikan')->group(function () {
        Route::get('/kalender', [\App\Http\Controllers\Api\PendidikanController::class, 'kalender']);
        Route::get('/e-rapor', [\App\Http\Controllers\Api\PendidikanController::class, 'eRapor']);
        Route::get('/ijazah', [\App\Http\Controllers\Api\PendidikanController::class, 'ijazah']);
    });

    // Hafalan Routes
    Route::get('/hafalan', [\App\Http\Controllers\Api\HafalanController::class, 'index']);
});

