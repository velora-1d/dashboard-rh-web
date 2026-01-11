<?php

namespace App\Http\Controllers;

use App\Models\Talaran;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TalaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('n')); // default current month index 1-12
        $tahun = $request->input('tahun', date('Y'));
        $kelasId = $request->input('kelas_id');

        $query = Santri::where('is_active', true)->with('kelas');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $santriList = $query->orderBy('nama_santri')->paginate(15)->appends($request->except('page'));
        
        // Manual Eager Loading to avoid modifying Santri model
        $talaranRecords = Talaran::whereIn('santri_id', $santriList->pluck('id'))
            ->where('bulan', (string)$bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('santri_id');

        $kelasList = Kelas::all();

        return view('pendidikan.talaran.index', compact('santriList', 'talaranRecords', 'kelasList', 'bulan', 'tahun', 'kelasId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'minggu_1' => 'nullable|integer|min:0',
            'minggu_2' => 'nullable|integer|min:0',
            'minggu_3' => 'nullable|integer|min:0',
            'minggu_4' => 'nullable|integer|min:0',
            'tamat' => 'nullable|integer|min:0',
            'alfa' => 'nullable|integer|min:0',
            'tamat_1_2' => 'nullable|integer|min:0',
            'alfa_1_2' => 'nullable|integer|min:0',
        ]);

        $data = $this->calculateData($validated);

        Talaran::updateOrCreate(
            [
                'santri_id' => $validated['santri_id'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
            ],
            $data
        );

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $talaran = Talaran::findOrFail($id);
        
        $validated = $request->validate([
            'minggu_1' => 'nullable|integer|min:0',
            'minggu_2' => 'nullable|integer|min:0',
            'minggu_3' => 'nullable|integer|min:0',
            'minggu_4' => 'nullable|integer|min:0',
            'tamat' => 'nullable|integer|min:0',
            'alfa' => 'nullable|integer|min:0',
            'tamat_1_2' => 'nullable|integer|min:0',
            'alfa_1_2' => 'nullable|integer|min:0',
        ]);

        $data = $this->calculateData($validated);

        $talaran->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Talaran::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    
    /**
     * Calculate derived fields
     */
    private function calculateData($validated)
    {
        $m1 = $validated['minggu_1'] ?? 0;
        $m2 = $validated['minggu_2'] ?? 0;
        $m3 = $validated['minggu_3'] ?? 0;
        $m4 = $validated['minggu_4'] ?? 0;
        
        $tamat_1_2 = $validated['tamat_1_2'] ?? 0;
        $tamat_3_4 = $validated['tamat'] ?? 0; // 'tamat' input is for period 3-4/total
        
        $alfa_1_2 = $validated['alfa_1_2'] ?? 0;
        $alfa_3_4 = $validated['alfa'] ?? 0;
        
        $jumlah_1_2 = $m1 + $m2;
        $jumlah_3_4 = $m3 + $m4;
        $jumlah_total = $jumlah_1_2 + $jumlah_3_4;
        
        return [
            'minggu_1' => $m1,
            'minggu_2' => $m2,
            'minggu_3' => $m3,
            'minggu_4' => $m4,
            'tamat_1_2' => $tamat_1_2,
            'alfa_1_2' => $alfa_1_2,
            'tamat' => $tamat_3_4,
            'alfa' => $alfa_3_4,
            
            // Calculated Fields
            'jumlah_1_2' => $jumlah_1_2,
            'jumlah_3_4' => $jumlah_3_4,
            'jumlah' => $jumlah_total,
            
            'total_1_2' => $this->formatTotalString($jumlah_1_2, $tamat_1_2),
            'total_3_4' => $this->formatTotalString($jumlah_3_4, $tamat_3_4),
            'total' => $this->formatTotalString($jumlah_total, $tamat_3_4) // Grand total logic
        ];
    }

    private function formatTotalString($jumlah, $tamat)
    {
        if ($tamat > 0) {
            return "{$tamat}x tamat + {$jumlah} bait/jajar";
        }
        return "{$jumlah} bait/jajar";
    }
    
    // PDF Methods
    public function cetakOneTwo(Request $request)
    {
        return $this->printPdf($request, 'pendidikan.talaran.pdf.1-2', '1-2');
    }
    
    public function cetakThreeFour(Request $request)
    {
        return $this->printPdf($request, 'pendidikan.talaran.pdf.3-4', '3-4');
    }
    
    public function cetakFull(Request $request)
    {
        return $this->printPdf($request, 'pendidikan.talaran.pdf.full', 'full');
    }
    
    private function printPdf(Request $request, $view, $type)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));
        $kelasId = $request->input('kelas_id');
        
        $query = Santri::where('is_active', true)->with('kelas');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        
        // Ordering by Class then Name
        $santriList = $query
            ->get()
            ->sortBy(function($santri) {
                return sprintf('%s-%s', $santri->kelas->nama_kelas ?? 'Z', $santri->nama_santri);
            });

        // Manual Loading
        $talaranRecords = Talaran::whereIn('santri_id', $santriList->pluck('id'))
            ->where('bulan', (string)$bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('santri_id');
            
        $kelasName = $kelasId ? Kelas::find($kelasId)->nama_kelas : 'Semua Kelas';
        // Simple Month Name
        $dateObj = \DateTime::createFromFormat('!m', $bulan);
        $monthName = $dateObj ? $dateObj->format('F') : $bulan;

        return view($view, compact('santriList', 'talaranRecords', 'bulan', 'tahun', 'kelasName', 'monthName'));
    }
}
