<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Perizinan;

class SekretarisController extends Controller
{
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
                    'status' => $p->status, // misal: aktif, kembali, terlambat
                ];
            })
        ]);
    }
}
