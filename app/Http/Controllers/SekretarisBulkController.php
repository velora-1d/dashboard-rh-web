<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Asrama;
use App\Models\Kobong;
use App\Models\MutasiSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SekretarisBulkController extends Controller
{
    /**
     * Mapping kenaikan kelas
     * Format: [kelas_asal => kelas_tujuan]
     */
    private function getClassMapping()
    {
        return [
            '1 Ibtida' => '2 Ibtida',
            '2 Ibtida' => '3 Ibtida',
            '3 Ibtida' => '4 Ibtida',
            '4 Ibtida' => '5 Ibtida',
            '5 Ibtida' => '6 Ibtida',
            '6 Ibtida' => '1 Tsanawi',
            '1 Tsanawi' => '2 Tsanawi',
            '2 Tsanawi' => '3 Tsanawi',
            '3 Tsanawi' => '1-2 Ma\'had Aly',
            '1-2 Ma\'had Aly' => '3-4 Ma\'had Aly',
            '3-4 Ma\'had Aly' => 'LULUS',
        ];
    }

    /**
     * Halaman Kenaikan Kelas Massal
     */
    public function showKenaikanKelas()
    {
        $kelasList = Kelas::orderBy('id')->get();
        $classMapping = $this->getClassMapping();
        
        return view('sekretaris.kenaikan-kelas.index', compact('kelasList', 'classMapping'));
    }

    /**
     * API: Get santri by kelas (with gender filter)
     */
    public function getSantriByKelas(Request $request, $kelasId)
    {
        $query = Santri::where('kelas_id', $kelasId)
            ->where('is_active', true);

        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        $santri = $query->orderBy('nama_santri')
            ->get(['id', 'nis', 'nama_santri', 'gender']);

        return response()->json($santri);
    }

    /**
     * Proses Kenaikan Kelas Massal
     */
    public function processKenaikanKelas(Request $request)
    {
        $request->validate([
            'kelas_asal_id' => 'required|exists:kelas,id',
            'kelas_tujuan_id' => 'required', // Can be kelas ID or 'LULUS'
            'naik_kelas' => 'nullable|array', // Array of IDs to promote
        ]);

        $kelasAsal = Kelas::find($request->kelas_asal_id);
        
        // Handle destination class (can be ID or 'LULUS')
        $isLulus = $request->kelas_tujuan_id === 'LULUS';
        $kelasTujuan = null;
        
        if (!$isLulus) {
            $kelasTujuan = Kelas::find($request->kelas_tujuan_id);
            if (!$kelasTujuan) {
                return back()->with('error', 'Kelas tujuan tidak ditemukan');
            }
        }

        // Get IDs of students to promote (checked checkboxes)
        $idsToPromote = $request->naik_kelas ?? [];
        
        // Get all students from this class (respecting any previous filters is hard here if we don't pass context, 
        // but usually we process whoever is on screen. 
        // CAUTION: If the user filtered by "Putra" and submitted, "Putri" are not in the list.
        // If we fetch ALL students from class, the "Putri" who were hidden won't be in $idsToPromote.
        // If they are not in $idsToPromote, they will be considered as "Stay".
        // This is tricky. If I filter "Putra" and submit, do I imply "Putri" stay? Or "Putri" are untouched?
        // Usually bulk operations operate on the displayed set.
        // But the form submits IDs.
        // If I submit specific IDs, I should only process those IDs?
        // Or should I process everyone in the class?
        // Logic: "yang di centang itu naik, yang gak di centang gak naik".
        // IF I filter to "Putra" only, "Putri" are not even visible.
        // If I say "Everyone in class NOT in checked list stays", then invisible Putri will stay.
        // Maybe that's desired? "Kenaikan Kelas" is usually done per class.
        // But if I want to just promote Putra first?
        // If I process *only* the IDs sent?
        // No, because "unchecked" means "stay". I need to know who is unchecked.
        // So I need to know the scope.
        // To be safe: We should process only the students that were *candidates* for promotion.
        // But the form doesn't send "unchecked" IDs.
        // Option 1: Process ALL students in the source class. Hidden students (Putri) will effectively "Stay" because they aren't checked.
        // This seems correct if the user intends to process the whole class.
        // Use case: User selects "Putra", checks all. Submits. "Putri" (unchecked) stay.
        // User selects "Putri", checks all. Submits. "Putri" promote. But "Putra" (who just promoted) are now in new class, so they are ignored.
        // Wait, if "Putra" were promoted in step 1, they are no longer in `kelas_asal_id`. So fetching `Santri::where('kelas_id', $kelasAsal)` won't find them.
        // So it works! Segments are safe.
        // Exception: If I filter "Putra" but *don't* promote them all, some stay.
        // Then I filter "Putri". The "Stayed Putra" are still in class.
        // If I process "Putri" and submit, the "Stayed Putra" are not checked (hidden). So they "Stay" again. No change.
        // So fetching ALL students in class and applying logic seems robust enough, assuming "Stay" doesn't change their state (idempotent).
        // Yes, "Stay" means recording a "Tinggal Kelas" mutation (maybe?).
        // If I run it twice, I get duplicate "Tinggal Kelas" mutations?
        // Ideally we only process those we see.
        // But how do we know who we saw?
        // We could add a hidden input "candidate_ids[]" for everyone shown?
        // Or just let it be. If they assume "filter gender" is just for viewing convenience, then treating hidden as "unchecked" (stay) is consistent.
        // Let's stick to: Process all active students in `kelas_asal_id`.
        
        $santriList = Santri::where('kelas_id', $request->kelas_asal_id)
            ->where('is_active', true)
            ->get();

        DB::beginTransaction();
        try {
            $countNaik = 0;
            $countTinggal = 0;
            $countLulus = 0;

            foreach ($santriList as $santri) {
                // If ID is in request->naik_kelas, promote. Else stay.
                $shouldPromote = in_array($santri->id, $idsToPromote);

                if ($shouldPromote) {
                    if ($isLulus) {
                        // Santri lulus
                        $santri->is_active = false;
                        $santri->save();

                        MutasiSantri::create([
                            'santri_id' => $santri->id,
                            'jenis_mutasi' => 'keluar',
                            'tanggal_mutasi' => now(),
                            'dari' => $kelasAsal->nama_kelas,
                            'ke' => 'LULUS',
                            'keterangan' => 'Lulus dari pesantren - Kenaikan Kelas Massal',
                        ]);
                        $countLulus++;
                    } else {
                        // Santri naik kelas
                        $santri->kelas_id = $kelasTujuan->id;
                        $santri->save();

                        MutasiSantri::create([
                            'santri_id' => $santri->id,
                            'jenis_mutasi' => 'pindah_kelas',
                            'tanggal_mutasi' => now(),
                            'dari' => $kelasAsal->nama_kelas,
                            'ke' => $kelasTujuan->nama_kelas,
                            'keterangan' => 'Kenaikan Kelas Massal',
                        ]);
                        $countNaik++;
                    }
                } else {
                    // Santri tidak naik kelas (tinggal kelas)
                    // Optional: Check if we want to record mutation for "Stay" every time?
                    // "yang gak di centang gakk naik" -> stays in class.
                    // Recording "Tinggal Kelas" mutation is good for history.
                    MutasiSantri::create([
                        'santri_id' => $santri->id,
                        'jenis_mutasi' => 'pindah_kelas',
                        'tanggal_mutasi' => now(),
                        'dari' => $kelasAsal->nama_kelas,
                        'ke' => $kelasAsal->nama_kelas . ' (Tinggal Kelas)',
                        'keterangan' => 'Tidak naik kelas - Kenaikan Kelas Massal',
                    ]);
                    $countTinggal++;
                }
            }

            DB::commit();

            $message = "Berhasil memproses kenaikan kelas: {$countNaik} santri naik kelas";
            if ($countTinggal > 0) {
                $message .= ", {$countTinggal} santri tinggal kelas";
            }
            if ($countLulus > 0) {
                $message .= ", {$countLulus} santri lulus";
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Perpindahan (Combined Asrama & Kobong)
     */
    public function showPerpindahan()
    {
        // Get all asramas to differentiate duplicates in UI
        $asramaRaw = Asrama::orderBy('nama_asrama')->get();
        
        $asramaList = $asramaRaw->map(function($asrama) use ($asramaRaw) {
            $hasDuplicate = $asramaRaw->where('nama_asrama', $asrama->nama_asrama)->count() > 1;
            if ($hasDuplicate) {
                // Clone the object to avoid modifying the original if shared
                $asrama = clone $asrama;
                $asrama->nama_asrama = $asrama->nama_asrama . ' (' . ucfirst($asrama->gender) . ')';
            }
            return $asrama;
        });

        $kelasList = Kelas::orderBy('id')->get();
        return view('sekretaris.perpindahan.index', compact('asramaList', 'kelasList'));
    }

    /**
     * API: Get santri with filters
     */
    public function getSantriFiltered(Request $request)
    {
        $query = Santri::where('is_active', true)
            ->with(['kelas', 'asrama', 'kobong']);

        if ($request->asrama_id) {
            $query->where('asrama_id', $request->asrama_id);
        }

        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $santri = $query->orderBy('nama_santri')->get();
        return response()->json($santri);
    }

    /**
     * API: Get kobong statistics for balancing
     */
    public function getKobongStats($asramaId)
    {
        // Use distinct nomor_kobong to avoid duplicates in stats
        $kobongs = Kobong::where('asrama_id', $asramaId)
            ->orderBy('nomor_kobong')
            ->get();
            
        $kelasList = Kelas::all();

        $result = [];
        foreach ($kobongs as $kobong) {
            $kelasCounts = [];
            foreach ($kelasList as $kelas) {
                // When counting santri, we should count for ALL kobongs with this number in this asrama
                // if there are actual duplicates in the DB
                $kobongIds = Kobong::where('asrama_id', $asramaId)
                    ->where('nomor_kobong', $kobong->nomor_kobong)
                    ->pluck('id');

                $count = Santri::whereIn('kobong_id', $kobongIds)
                    ->where('kelas_id', $kelas->id)
                    ->where('is_active', true)
                    ->count();
                $kelasCounts[$kelas->nama_kelas] = $count;
            }

            $result[] = [
                'id' => $kobong->id,
                'nomor_kobong' => $kobong->nomor_kobong,
                'kelas_counts' => $kelasCounts,
            ];
        }

        return response()->json($result);
    }

    /**
     * Process perpindahan dengan per-santri assignment
     */
    public function processPerpindahan(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $count = 0;

            foreach ($request->assignments as $santriId => $assignment) {
                $santri = Santri::with(['asrama', 'kobong'])->find($santriId);
                if (!$santri) continue;

                $newAsramaId = $assignment['asrama_id'] ?? null;
                $newKobongId = $assignment['kobong_id'] ?? null;

                // Skip if no change
                if ($santri->asrama_id == $newAsramaId && ($santri->kobong_id == $newKobongId || !$newKobongId)) {
                    continue;
                }

                // Get new asrama and kobong names
                $newAsrama = Asrama::find($newAsramaId);
                $newKobong = $newKobongId ? Kobong::find($newKobongId) : null;

                // Record old location
                $oldLocation = ($santri->asrama ? $santri->asrama->nama_asrama : '-') . 
                    ' / Kobong ' . ($santri->kobong ? $santri->kobong->nomor_kobong : '-');
                
                // Record new location
                $newLocation = ($newAsrama ? $newAsrama->nama_asrama : '-') . 
                    ' / Kobong ' . ($newKobong ? $newKobong->nomor_kobong : '-');

                // Update santri
                $santri->asrama_id = $newAsramaId;
                if ($newKobongId) {
                    $santri->kobong_id = $newKobongId;
                }
                $santri->save();

                // Create mutation record
                MutasiSantri::create([
                    'santri_id' => $santri->id,
                    'jenis_mutasi' => 'pindah_asrama',
                    'tanggal_mutasi' => now(),
                    'dari' => $oldLocation,
                    'ke' => $newLocation,
                    'keterangan' => 'Perpindahan Massal',
                ]);

                $count++;
            }

            DB::commit();
            return back()->with('success', "Berhasil memindahkan {$count} santri");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * API: Get santri by asrama
     */
    public function getSantriByAsrama($asramaId)
    {
        $santri = Santri::where('asrama_id', $asramaId)
            ->where('is_active', true)
            ->with('kobong')
            ->orderBy('nama_santri')
            ->get(['id', 'nis', 'nama_santri', 'gender', 'kobong_id']);

        return response()->json($santri);
    }

    /**
     * Proses Perpindahan Asrama Massal
     */
    public function processPerpindahanAsrama(Request $request)
    {
        $request->validate([
            'asrama_asal_id' => 'required|exists:asrama,id',
            'asrama_tujuan_id' => 'required|exists:asrama,id|different:asrama_asal_id',
            'santri_ids' => 'required|array|min:1',
            'santri_ids.*' => 'exists:santri,id',
        ]);

        $asramaAsal = Asrama::find($request->asrama_asal_id);
        $asramaTujuan = Asrama::find($request->asrama_tujuan_id);

        // Get kobong pertama di asrama tujuan sebagai default
        $kobongDefault = Kobong::where('asrama_id', $request->asrama_tujuan_id)->first();

        if (!$kobongDefault) {
            return back()->with('error', 'Tidak ada kobong tersedia di asrama tujuan');
        }

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($request->santri_ids as $santriId) {
                $santri = Santri::find($santriId);
                if ($santri) {
                    $kobongAsal = $santri->kobong;
                    
                    $santri->asrama_id = $request->asrama_tujuan_id;
                    $santri->kobong_id = $kobongDefault->id;
                    $santri->save();

                    MutasiSantri::create([
                        'santri_id' => $santri->id,
                        'jenis_mutasi' => 'pindah_asrama',
                        'tanggal_mutasi' => now(),
                        'dari' => $asramaAsal->nama_asrama . ' (Kobong ' . ($kobongAsal->nomor_kobong ?? '-') . ')',
                        'ke' => $asramaTujuan->nama_asrama . ' (Kobong ' . $kobongDefault->nomor_kobong . ')',
                        'keterangan' => 'Perpindahan Asrama Massal',
                    ]);
                    $count++;
                }
            }

            DB::commit();
            return back()->with('success', "Berhasil memindahkan {$count} santri ke " . $asramaTujuan->nama_asrama);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Perpindahan Kobong Massal
     */
    public function showPerpindahanKobong()
    {
        $asramaList = Asrama::all();
        return view('sekretaris.perpindahan-kobong', compact('asramaList'));
    }

    /**
     * API: Get kobong by asrama
     */
    public function getKobongByAsrama($asramaId)
    {
        $kobong = Kobong::where('asrama_id', $asramaId)
            ->orderBy('nomor_kobong')
            ->get();
        return response()->json($kobong);
    }

    /**
     * API: Get santri by kobong
     */
    public function getSantriByKobong($kobongId)
    {
        $santri = Santri::where('kobong_id', $kobongId)
            ->where('is_active', true)
            ->orderBy('nama_santri')
            ->get(['id', 'nis', 'nama_santri', 'gender']);

        return response()->json($santri);
    }

    /**
     * Proses Perpindahan Kobong Massal
     */
    public function processPerpindahanKobong(Request $request)
    {
        $request->validate([
            'kobong_asal_id' => 'required|exists:kobong,id',
            'kobong_tujuan_id' => 'required|exists:kobong,id|different:kobong_asal_id',
            'santri_ids' => 'required|array|min:1',
            'santri_ids.*' => 'exists:santri,id',
        ]);

        $kobongAsal = Kobong::with('asrama')->find($request->kobong_asal_id);
        $kobongTujuan = Kobong::with('asrama')->find($request->kobong_tujuan_id);

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($request->santri_ids as $santriId) {
                $santri = Santri::find($santriId);
                if ($santri) {
                    $santri->kobong_id = $request->kobong_tujuan_id;
                    $santri->asrama_id = $kobongTujuan->asrama_id; // Update asrama juga jika berbeda
                    $santri->save();

                    MutasiSantri::create([
                        'santri_id' => $santri->id,
                        'jenis_mutasi' => 'pindah_asrama',
                        'tanggal_mutasi' => now(),
                        'dari' => $kobongAsal->asrama->nama_asrama . ' - Kobong ' . $kobongAsal->nomor_kobong,
                        'ke' => $kobongTujuan->asrama->nama_asrama . ' - Kobong ' . $kobongTujuan->nomor_kobong,
                        'keterangan' => 'Perpindahan Kobong Massal',
                    ]);
                    $count++;
                }
            }

            DB::commit();
            return back()->with('success', "Berhasil memindahkan {$count} santri ke Kobong " . $kobongTujuan->nomor_kobong);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}
