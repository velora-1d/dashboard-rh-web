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
        Route::get('/get-filters', [\App\Http\Controllers\Api\SekretarisController::class, 'getFilters']);
        Route::get('/santri', [\App\Http\Controllers\Api\SekretarisController::class, 'index']);
        Route::get('/perizinan', [\App\Http\Controllers\Api\SekretarisController::class, 'perizinan']);
        Route::post('/perizinan', [\App\Http\Controllers\Api\SekretarisController::class, 'storePerizinan']);
    });



    // Bendahara Routes
    Route::prefix('bendahara')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\BendaharaController::class, 'dashboard']);
        Route::get('/kas', [\App\Http\Controllers\Api\BendaharaController::class, 'kas']);
        Route::post('/kas', [\App\Http\Controllers\Api\BendaharaController::class, 'storeKas']);
        Route::get('/cek-tunggakan', [\App\Http\Controllers\Api\BendaharaController::class, 'cekTunggakan']);
    });


    // Pendidikan Routes
    Route::prefix('pendidikan')->group(function () {
        Route::get('/kalender', [\App\Http\Controllers\Api\PendidikanController::class, 'kalender']);
        Route::get('/e-rapor', [\App\Http\Controllers\Api\PendidikanController::class, 'eRapor']);
        Route::get('/ijazah', [\App\Http\Controllers\Api\PendidikanController::class, 'ijazah']);
    });

    // Notifications Routes
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Api\NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'markAllAsRead']);
});

