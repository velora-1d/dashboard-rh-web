<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kalender;
use App\Models\Hafalan;

class PendidikanController extends Controller
{
    public function kalender()
    {
        $kalender = Kalender::orderBy('tanggal', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $kalender
        ]);
    }

    public function eRapor(Request $request)
    {
        // Simple mock/placeholder logic for grades
        return response()->json([
            'status' => 'success',
            'data' => [
                ['mapel' => 'Al-Quran', 'nilai' => 85, 'kkm' => 75],
                ['mapel' => 'Fiqih', 'nilai' => 90, 'kkm' => 75],
                ['mapel' => 'Bahasa Arab', 'nilai' => 88, 'kkm' => 75],
            ]
        ]);
    }

    public function ijazah()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                ['judul' => 'Ijazah MDT 2024', 'tgl_terbit' => '2024-06-01', 'url' => '#'],
                ['judul' => 'Sertifikat Tahfidz', 'tgl_terbit' => '2024-05-15', 'url' => '#'],
            ]
        ]);
    }
}
