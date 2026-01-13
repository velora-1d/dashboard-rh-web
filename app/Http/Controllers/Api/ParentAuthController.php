<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use Carbon\Carbon;

class ParentAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nama_santri' => 'required|string',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
        ]);

        // Cari Santri berdasarkan Nama & Tanggal Lahir (Login)
        // Kita gunakan LIKE untuk nama santri agar lebih fleksibel (case insensitive biasanya default di MySQL)
        $santri = Santri::where('nama_santri', 'like', $request->nama_santri)
            ->whereDate('tanggal_lahir', $request->tanggal_lahir)
            ->where('is_active', true)
            ->first();

        // Jika tidak ditemukan
        if (!$santri) {
            // Coba cari nama mirip saja untuk pesan error yang lebih jelas (opsional)
            $nameExists = Santri::where('nama_santri', 'like', $request->nama_santri)->exists();
            
            if ($nameExists) {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal lahir salah. Pastikan format YYYY-MM-DD.',
                ], 401);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Data santri tidak ditemukan. Periksa ejaan nama dan tanggal lahir.',
            ], 401);
        }

        // Login Berhasil -> Buat Token Sanctum
        $token = $santri->createToken('parent-token:' . $santri->nis)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'santri' => $santri->makeHidden(['virtual_account_number', 'updated_at', 'created_at']), // Sembunyikan data sensitif jika perlu
                'role' => 'wali_santri'
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user() // Mengembalikan object Santri karena token terikat ke Santri
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success', 'message' => 'Logout berhasil']);
    }
}
