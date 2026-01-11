<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Santri;
use App\Models\UjianMingguan;
use Illuminate\Support\Facades\DB;

class NilaiMingguanController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $mapelId = $request->get('mapel_id');
        $tahunAjaran = $request->get('tahun_ajaran', '2025/2026'); // Default hardcoded for now or fetch global setting
        $semester = $request->get('semester', '1');

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        // Only fetch Mapel that are flagged as 'Talaran'
        $mapelList = MataPelajaran::where('is_talaran', true)->orderBy('nama_mapel')->get();

        $santriList = [];
        $existingNilai = [];

        if ($kelasId && $mapelId) {
            $santriList = Santri::where('kelas_id', $kelasId)
                                ->where('is_active', true)
                                ->orderBy('nama_santri')
                                ->get();

            $existingNilai = UjianMingguan::where('kelas_id', $kelasId)
                                ->where('mapel_id', $mapelId)
                                ->where('tahun_ajaran', $tahunAjaran)
                                ->where('semester', $semester)
                                ->get()
                                ->keyBy('santri_id');
        }

        if ($request->ajax()) {
            return view('pendidikan.nilai-mingguan.table', compact(
                'kelasList', 
                'mapelList', 
                'santriList', 
                'existingNilai',
                'kelasId',
                'mapelId',
                'tahunAjaran',
                'semester'
            ));
        }

        return view('pendidikan.nilai-mingguan.index', compact(
            'kelasList', 
            'mapelList', 
            'santriList', 
            'existingNilai',
            'kelasId',
            'mapelId',
            'tahunAjaran',
            'semester'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'nilai' => 'array',
        ]);

        $kelasId = $request->kelas_id;
        $mapelId = $request->mapel_id;
        $tahunAjaran = $request->tahun_ajaran;
        $semester = $request->semester;

        DB::beginTransaction();
        try {
            foreach ($request->nilai as $santriId => $scores) {
                // Calculate Average
                $m1 = $scores['m1'] ?? 0;
                $m2 = $scores['m2'] ?? 0;
                $m3 = $scores['m3'] ?? 0;
                $m4 = $scores['m4'] ?? 0;
                
                // Count non-null inputs for proper average? Or just strict /4?
                // User said "4x ulangan mingguan". Assuming /4.
                // But better to verify if user meant "up to 4". 
                // Let's assume strict average of entered values or standard /4.
                // For simplicity: (m1+m2+m3+m4)/4 is standard school logic, but if m4 is empty (not yet done), 
                // it penalizes. 
                // Better logic: (Sum of filled) / (Count of filled).
                
                $filledCount = 0;
                $sum = 0;
                if(isset($scores['m1']) && $scores['m1'] !== null) { $sum += $scores['m1']; $filledCount++; }
                if(isset($scores['m2']) && $scores['m2'] !== null) { $sum += $scores['m2']; $filledCount++; }
                if(isset($scores['m3']) && $scores['m3'] !== null) { $sum += $scores['m3']; $filledCount++; }
                if(isset($scores['m4']) && $scores['m4'] !== null) { $sum += $scores['m4']; $filledCount++; }
                
                $average = $filledCount > 0 ? $sum / $filledCount : 0;

                UjianMingguan::updateOrCreate(
                    [
                        'santri_id' => $santriId,
                        'mapel_id' => $mapelId,
                        'kelas_id' => $kelasId,
                        'tahun_ajaran' => $tahunAjaran,
                        'semester' => $semester,
                    ],
                    [
                        'minggu_1' => $scores['m1'],
                        'minggu_2' => $scores['m2'],
                        'minggu_3' => $scores['m3'],
                        'minggu_4' => $scores['m4'],
                        'rata_rata' => $average
                    ]
                );

                // SYNC TO REKAPITULASI (Modal Awal)
                // Fetch existing NilaiSantri to keep exam scores if they exist
                $rekap = \App\Models\NilaiSantri::where([
                    'santri_id' => $santriId,
                    'mapel_id' => $mapelId,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                ])->first();

                $nilaiUjian = $rekap ? $rekap->nilai_uts : 0; // Use UTS as the placeholder for exam score in bulk store
                
                // Formula: 30% Weekly + 70% Ujian
                $nilaiAkhirAccumulated = ($average * 0.3) + ($nilaiUjian * 0.7);

                \App\Models\NilaiSantri::updateOrCreate(
                    [
                        'santri_id' => $santriId,
                        'mapel_id' => $mapelId,
                        'tahun_ajaran' => $tahunAjaran,
                        'semester' => $semester,
                    ],
                    [
                        'kelas_id' => $kelasId,
                        'nilai_tugas' => $average, // Store weekly average as Task/Assignment
                        'nilai_akhir' => $nilaiAkhirAccumulated,
                        'updated_at' => now(),
                    ]
                );
            }
            DB::commit();
            
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Nilai Mingguah berhasil disimpan', 'success' => true]);
            }

            return redirect()->back()->with('success', 'Nilai Mingguan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menyimpan: ' . $e->getMessage(), 'success' => false], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}
