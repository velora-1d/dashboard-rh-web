<?php

namespace App\Http\Controllers;

use App\Models\UjianMingguan;
use App\Models\Santri;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjianMingguanController extends Controller
{
    /**
     * Display weekly exam input form
     */
    public function index(Request $request)
    {
        // Get filter options
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaranList = ['2024-2025', '2025-2026', '2026-2027'];
        $tahunAjaran = $request->input('tahun_ajaran', '2025-2026');
        
        // Get subjects that have weekly exams (is_talaran checkbox in Data Mata Ujian)
        $mapelList = MataPelajaran::where('is_talaran', true)
            ->where('is_active', true)
            ->orderBy('nama_mapel')
            ->get();
        
        $santriList = collect();
        $selectedMapel = null;
        
        if ($request->filled(['kelas_id', 'mapel_id'])) {
            $kelasId = $request->input('kelas_id');
            $mapelId = $request->input('mapel_id');
            $semester = $request->input('semester', '1');
            
            $selectedMapel = MataPelajaran::find($mapelId);
            
            // Get all santri in this class
            $santriQuery = Santri::where('kelas_id', $kelasId);
            
            // Filter by gender if specified
            if ($request->filled('gender')) {
                $santriQuery->where('gender', $request->input('gender'));
            }
            
            // Eager load weekly exam data
            $santriList = $santriQuery->with(['ujianMingguan' => function($q) use ($mapelId, $tahunAjaran, $semester) {
                $q->where('mapel_id', $mapelId)
                  ->where('tahun_ajaran', $tahunAjaran)
                  ->where('semester', $semester);
            }])->orderBy('nama_santri')->get();
        }
        
        return view('pendidikan.ujian-mingguan.index', compact(
            'kelasList',
            'tahunAjaranList',
            'tahunAjaran',
            'mapelList',
            'santriList',
            'selectedMapel'
        ));
    }
    
    /**
     * Store weekly exam scores
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:1,2',
            'santri' => 'required|array',
            'santri.*.id' => 'required|exists:santri,id',
            'santri.*.minggu_1' => 'nullable|numeric|min:0|max:100',
            'santri.*.minggu_2' => 'nullable|numeric|min:0|max:100',
            'santri.*.minggu_3' => 'nullable|numeric|min:0|max:100',
            'santri.*.minggu_4' => 'nullable|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        try {
            foreach ($validated['santri'] as $santriData) {
                // Find or create weekly exam record
                $ujian = UjianMingguan::updateOrCreate(
                    [
                        'santri_id' => $santriData['id'],
                        'mapel_id' => $validated['mapel_id'],
                        'tahun_ajaran' => $validated['tahun_ajaran'],
                        'semester' => $validated['semester'],
                    ],
                    [
                        'minggu_1' => $santriData['minggu_1'] ?? null,
                        'minggu_2' => $santriData['minggu_2'] ?? null,
                        'minggu_3' => $santriData['minggu_3'] ?? null,
                        'minggu_4' => $santriData['minggu_4'] ?? null,
                    ]
                );
                
                // Calculate status and nilai_hasil_mingguan
                $ujian->calculateStatus();
                $ujian->save();
            }
            
            DB::commit();
            
            return redirect()->route('pendidikan.ujian-mingguan', $request->only(['kelas_id', 'mapel_id', 'tahun_ajaran', 'semester', 'gender']))
                ->with('success', 'Data ujian mingguan berhasil disimpan dan dihitung');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
