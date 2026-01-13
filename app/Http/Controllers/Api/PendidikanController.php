<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KalenderPendidikan;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Support\Facades\URL;

class PendidikanController extends Controller
{
    // Kalender Akademik
    public function getKalender(Request $request)
    {
        $query = KalenderPendidikan::orderBy('tanggal_mulai', 'asc');
        
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $events = $query->get()->map(function($item) {
            return [
                'id' => $item->id,
                'judul' => $item->judul,
                'deskripsi' => $item->deskripsi,
                'tanggal_mulai' => $item->tanggal_mulai,
                'tanggal_selesai' => $item->tanggal_selesai,
                'kategori' => $item->kategori,
                'warna' => $item->warna
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $events
        ]);
    }

    public function storeKalender(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'warna' => 'required|string', // merah, hijau, biru, kuning, ungu
            'kategori' => 'required|string',
        ]);

        $kalender = KalenderPendidikan::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil ditambahkan',
            'data' => $kalender
        ]);
    }

    public function updateKalender(Request $request, $id)
    {
        $kalender = KalenderPendidikan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'warna' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $kalender->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil diperbarui',
            'data' => $kalender
        ]);
    }

    public function destroyKalender($id)
    {
        $kalender = KalenderPendidikan::findOrFail($id);
        $kalender->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil dihapus'
        ]);
    }

    // E-Rapor: Get Class List
    public function getKelasList()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return response()->json(['status' => 'success', 'data' => $kelas]);
    }

    // E-Rapor: Get Santri by Class
    public function getSantriByKelas(Request $request, $kelasId)
    {
        $santri = Santri::where('kelas_id', $kelasId)
            ->where('is_active', true)
            ->orderBy('nama_santri')
            ->select('id', 'nis', 'nama_santri', 'gender', 'no_hp_ortu_wali')
            ->get();
            
        return response()->json(['status' => 'success', 'data' => $santri]);
    }

    // E-Rapor: Generate Download URL
    public function getRaporUrl(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:1,2'
        ]);

        $url = URL::temporarySignedRoute(
            'api.pendidikan.download-rapor',
            now()->addMinutes(30),
            [
                'santri_id' => $request->santri_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'download' => '1'
            ]
        );

        return response()->json(['status' => 'success', 'url' => $url]);
    }

    // E-Rapor: Download Handler
    public function downloadRapor(Request $request)
    {
        $webController = new \App\Http\Controllers\PendidikanController();
        return $webController->exportRapor($request);
    }

    // Ijazah: Generate Download URL
    public function getIjazahUrl(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'type' => 'required|in:ibtida,tsanawi'
        ]);

        $url = URL::temporarySignedRoute(
            'api.pendidikan.download-ijazah',
            now()->addMinutes(30),
            [
                'santri_id' => $request->santri_id,
                'type' => $request->type,
                'download' => '1'
            ]
        );

        return response()->json(['status' => 'success', 'url' => $url]);
    }

    // Ijazah: Download Handler
    public function downloadIjazah(Request $request, $type, $santriId)
    {
       $webController = new \App\Http\Controllers\PendidikanController();
       return $webController->cetakIjazahSantri($type, $santriId);
    }
    
    // E-Rapor: Get Subjects by Class
    public function getMapelList(Request $request)
    {
        $query = \App\Models\MataPelajaran::where('is_active', true);
        
        if ($request->has('kelas_id')) {
            $kelasId = $request->kelas_id;
            $query->where(function($q) use ($kelasId) {
                $q->whereDoesntHave('kelas')
                  ->orWhereHas('kelas', function($qk) use ($kelasId) {
                      $qk->where('kelas.id', $kelasId);
                  });
            });
        }
        
        $mapel = $query->orderBy('nama_mapel')->get();
        return response()->json(['status' => 'success', 'data' => $mapel]);
    }

    // E-Rapor: Bulk Store Grades
    public function storeNilaiBulk(Request $request)
    {
        $webController = new \App\Http\Controllers\PendidikanController();
        
        try {
            return $webController->storeNilaiBulk($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // --- HAFALAN SANTRI ---

    public function getHafalan(Request $request)
    {
        $query = \App\Models\Hafalan::with(['santri.kelas']);

        if ($request->has('kelas_id')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->has('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        
        // Search by Santri Name
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%");
            });
        }

        $hafalan = $query->orderBy('tanggal', 'desc')->take(50)->get();

        return response()->json(['status' => 'success', 'data' => $hafalan]);
    }

    public function storeHafalan(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string',
            'progress' => 'required|string',
            'tanggal' => 'required|date',
            'nilai' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $hafalan = \App\Models\Hafalan::create([
            'santri_id' => $request->santri_id,
            'jenis' => $request->jenis,
            'nama_hafalan' => $request->nama_hafalan,
            'progress' => $request->progress,
            'tanggal' => $request->tanggal,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'created_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Hafalan berhasil dicatat', 
            'data' => $hafalan
        ]);
    }

    public function updateHafalan(Request $request, $id)
    {
        $hafalan = \App\Models\Hafalan::findOrFail($id);

        $request->validate([
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string',
            'progress' => 'required|string',
            'tanggal' => 'required|date',
            'nilai' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $hafalan->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data hafalan diperbarui',
            'data' => $hafalan
        ]);
    }

    public function destroyHafalan($id)
    {
        $hafalan = \App\Models\Hafalan::findOrFail($id);
        $hafalan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data hafalan dihapus'
        ]);
    }
}
