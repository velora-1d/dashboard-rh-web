<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BendaharaController;
use App\Http\Controllers\Api\SekretarisController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\NotificationController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/fcm-token', [AuthController::class, 'updateFcmToken']);

    // Sekretaris Routes
    Route::prefix('sekretaris')->group(function () {
        Route::get('/dashboard', [SekretarisController::class, 'dashboard']);
        Route::get('/get-filters', [SekretarisController::class, 'getFilters']);
        Route::get('/santri', [SekretarisController::class, 'index']);
        Route::post('/santri', [SekretarisController::class, 'storeSantri']);
        Route::put('/santri/{id}', [SekretarisController::class, 'updateSantri']);
        Route::delete('/santri/{id}', [SekretarisController::class, 'deactivateSantri']);
        Route::get('/perizinan', [SekretarisController::class, 'perizinan']);
        Route::post('/perizinan', [SekretarisController::class, 'storePerizinan']);
        Route::put('/perizinan/{id}', [SekretarisController::class, 'updatePerizinan']);
        Route::delete('/perizinan/{id}', [SekretarisController::class, 'destroyPerizinan']);
        Route::post('/perizinan/{id}/approval', [SekretarisController::class, 'approvePerizinan']);
        
        // Laporan
        Route::post('/laporan/url', [SekretarisController::class, 'getLaporanUrl']);
    });

    // Bendahara Routes
    Route::prefix('bendahara')->group(function () {
        Route::get('/dashboard', [BendaharaController::class, 'dashboard']);
        Route::get('/kas', [BendaharaController::class, 'kas']);
        Route::post('/kas', [BendaharaController::class, 'storeKas']);
        Route::put('/kas/{id}', [BendaharaController::class, 'updateKas']);
        Route::delete('/kas/{id}', [BendaharaController::class, 'destroyKas']);

        Route::get('/cek-tunggakan', [BendaharaController::class, 'cekTunggakan']);
        Route::get('/bank-accounts', [BendaharaController::class, 'getBankAccounts']);
        Route::post('/bank-accounts', [BendaharaController::class, 'storeBankAccount']);
        Route::get('/withdrawals', [BendaharaController::class, 'getWithdrawals']);
        Route::post('/withdrawals', [BendaharaController::class, 'requestWithdrawal']);
        
        Route::get('/syahriah', [BendaharaController::class, 'getSyahriah']);
        Route::post('/syahriah', [BendaharaController::class, 'storeSyahriah']);
        Route::put('/syahriah/{id}', [BendaharaController::class, 'updateSyahriah']);
        Route::delete('/syahriah/{id}', [BendaharaController::class, 'destroySyahriah']);
        
        // Pegawai
        Route::get('/pegawai', [BendaharaController::class, 'getPegawai']);
        Route::post('/pegawai', [BendaharaController::class, 'storePegawai']);
        Route::put('/pegawai/{id}', [BendaharaController::class, 'updatePegawai']);
        Route::delete('/pegawai/{id}', [BendaharaController::class, 'destroyPegawai']);

        // Gaji
        Route::get('/gaji', [BendaharaController::class, 'getGaji']);
        Route::post('/gaji', [BendaharaController::class, 'storeGaji']);
        Route::put('/gaji/{id}', [BendaharaController::class, 'updateGaji']);
        Route::delete('/gaji/{id}', [BendaharaController::class, 'destroyGaji']);

        // Laporan
        Route::get('/laporan', [BendaharaController::class, 'getLaporanSummary']);
        Route::post('/laporan/url', [BendaharaController::class, 'getLaporanUrl']);
    });

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/withdrawals', [AdminController::class, 'trackingWithdrawals']);
        Route::post('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal']);
    });

    // Pendidikan Routes
    Route::prefix('pendidikan')->group(function () {
        Route::get('/kalender', [PendidikanController::class, 'getKalender']);
        Route::post('/kalender', [PendidikanController::class, 'storeKalender']);
        Route::put('/kalender/{id}', [PendidikanController::class, 'updateKalender']);
        Route::delete('/kalender/{id}', [PendidikanController::class, 'destroyKalender']);
        Route::get('/kelas', [PendidikanController::class, 'getKelasList']);
        Route::get('/kelas/{id}/santri', [PendidikanController::class, 'getSantriByKelas']);
        Route::post('/rapor/url', [PendidikanController::class, 'getRaporUrl']);
        Route::post('/ijazah/url', [PendidikanController::class, 'getIjazahUrl']);
        Route::get('/mapel', [PendidikanController::class, 'getMapelList']);
        Route::post('/nilai/bulk', [PendidikanController::class, 'storeNilaiBulk']);
    });

    // Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});

// Public Signed Routes for Downloads
Route::get('/pendidikan/rapor/download', [PendidikanController::class, 'downloadRapor'])
    ->name('api.pendidikan.download-rapor')->middleware('signed');

Route::get('/pendidikan/ijazah/download/{type}/{santriId}', [PendidikanController::class, 'downloadIjazah'])
    ->name('api.pendidikan.download-ijazah')->middleware('signed');

Route::get('/sekretaris/laporan/download', [SekretarisController::class, 'downloadLaporan'])
    ->name('api.sekretaris.download-laporan')->middleware('signed');

Route::get('/bendahara/laporan/download', [BendaharaController::class, 'downloadLaporan'])
    ->name('api.bendahara.download-laporan')->middleware('signed');
