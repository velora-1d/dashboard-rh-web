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
        $santriId = $request->santri_id;

        // Cek IDOR: Jika user yang login adalah Santri/Wali Santri, paksa santri_id ke ID login mereka
        if ($request->user() && clone $request->user() instanceof \App\Models\Santri) {
            $santriId = $request->user()->id;
        } else {
            // Jika admin/pendidikan/sekretaris, maka santri_id wajib ada dari request
            $request->validate(['santri_id' => 'required|exists:santri,id']);
        }
        
        $data = Perizinan::where('santri_id', $santriId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json(['data' => $data]);
    }

    // Request Izin Baru (Untuk Wali Santri)
    public function store(Request $request)
    {
        $santriId = $request->santri_id;

        // Cek IDOR: Jika user yang login adalah Santri/Wali Santri, paksa santri_id ke ID login mereka
        if ($request->user() && clone $request->user() instanceof \App\Models\Santri) {
            $santriId = $request->user()->id;
        }

        // Validate basic rules mapping $request->all() and injecting override
        $request->merge(['santri_id' => $santriId]);

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
