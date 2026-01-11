<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use App\Models\Santri;
use Illuminate\Support\Facades\Auth;

class PerizinanController extends Controller
{
    // List History Perizinan (Untuk Wali Santri)
    public function index(Request $request)
    {
        // Asumsi: User Login adalah Wali Santri yang punya relasi ke data Santri
        // Untuk MVP fase ini, kita ambil berdasarkan 'santri_id' yang dikirim param
        // Nanti harus di-binding dengan User Login (Parent)
        
        $request->validate(['santri_id' => 'required|exists:santri,id']);
        
        $data = Perizinan::where('santri_id', $request->santri_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json(['data' => $data]);
    }

    // Request Izin Baru (Untuk Wali Santri)
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Izin Pulang,Izin Keluar,Sakit',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'alasan' => 'required|string',
            'bukti_foto' => 'nullable|string' // Base64 or URL
        ]);

        $perizinan = Perizinan::create([
            'santri_id' => $request->santri_id,
            'jenis' => $request->jenis,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'alasan' => $request->alasan,
            'status' => 'Pending',
            'bukti_foto' => $request->bukti_foto
        ]);

        return response()->json([
            'message' => 'Pengajuan izin berhasil dikirim',
            'data' => $perizinan
        ], 201);
    }
}
