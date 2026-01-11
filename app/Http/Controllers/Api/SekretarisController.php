<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Perizinan;

class SekretarisController extends Controller
{
    public function getFilters()
    {
        $kelas = \App\Models\Kelas::select('id', 'nama_kelas')->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'kelas' => $kelas,
                'asrama' => [], // Placeholder for now
                'gender' => [
                    ['id' => 'L', 'label' => 'Laki-laki'],
                    ['id' => 'P', 'label' => 'Perempuan'],
                ]
            ]
        ]);
    }

    public function index(Request $request)

    {
        $query = Santri::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('asrama_id')) {
            $query->where('asrama_id', $request->asrama_id);
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        $santri = $query->with(['kelas'])->take(50)->get();

        return response()->json([
            'status' => 'success',
            'data' => $santri->map(function($s) {
                return [
                    'id' => $s->id,
                    'nama' => $s->nama_santri,
                    'nis' => $s->nis,
                    'kelas' => $s->kelas->nama_kelas ?? '-',
                    'kamar' => $s->kamar ?? '-',
                ];
            })
        ]);
    }


    public function perizinan()
    {
        $perizinan = Perizinan::with(['santri'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $perizinan->map(function($p) {
                return [
                    'id' => $p->id,
                    'nama_santri' => $p->santri->nama_santri ?? 'N/A',
                    'alasan' => $p->alasan,
                    'tgl_pulang' => $p->tgl_pulang,
                    'tgl_kembali' => $p->tgl_kembali,
                    'status' => $p->status,
                ];
            })
        ]);
    }

    public function storePerizinan(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'alasan' => 'required|string',
            'tgl_pulang' => 'required|date',
            'tgl_kembali' => 'required|date',
        ]);

        $perizinan = Perizinan::create([
            'santri_id' => $request->santri_id,
            'alasan' => $request->alasan,
            'tgl_pulang' => $request->tgl_pulang,
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'aktif',
        ]);

        // Create In-App Notification
        $santri = Santri::find($request->santri_id);
        \App\Models\Notification::create([
            'type' => 'perizinan',
            'title' => 'Perizinan Baru',
            'message' => "Izin baru diajukan untuk {$santri->nama_santri}: {$request->alasan}",
            'icon' => 'clock',
            'color' => '#f59e0b',
            'role' => 'sekretaris',
            'data' => [
                'perizinan_id' => $perizinan->id,
                'santri_id' => $santri->id,
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data perizinan berhasil disimpan',
            'data' => $perizinan
        ]);
    }
}

