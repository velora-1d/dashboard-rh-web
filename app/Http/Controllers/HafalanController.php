<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanController extends Controller
{
    public function index(Request $request)
    {
        $query = Hafalan::with('santri')->orderBy('tanggal', 'desc');

        // Filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $hafalan = $query->paginate(10);
        $kelasList = \App\Models\Kelas::orderBy('level')->orderBy('nama_kelas')->get();
        
        return view('pendidikan.hafalan.index', compact('hafalan', 'kelasList'));
    }

    public function create()
    {
        $santri = Santri::where('is_active', true)->with('kelas')->get();
        $kitabConfig = \App\Models\KitabTalaran::all()->groupBy('kelas_id'); // Load config for frontend logic
        return view('pendidikan.hafalan.create', compact('santri', 'kitabConfig'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string',
            'progress' => 'required|string',
            'tanggal' => 'required|date',
            'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        // Validation logic for Kitab: Ensure kitab matches class config
        if ($request->jenis === 'Kitab') {
            $santri = Santri::find($request->santri_id);
            $currentSemester = $this->getCurrentSemester(); // You might need a helper for this
            
            // Check if configured (Optional strictness, can be just a warning or auto-fill on frontend)
            // For now, allow it but maybe we can log or just let the frontend handle the suggestions
        }

        Hafalan::create([
            'santri_id' => $request->santri_id,
            'jenis' => $request->jenis,
            'nama_hafalan' => $request->nama_hafalan,
            'progress' => $request->progress,
            'tanggal' => $request->tanggal,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('pendidikan.hafalan.index')->with('success', 'Data hafalan berhasil disimpan.');
    }

    public function edit($id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $santri = Santri::where('is_active', true)->get();
        return view('pendidikan.hafalan.edit', compact('hafalan', 'santri'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string',
            'progress' => 'required|string',
            'tanggal' => 'required|date',
            'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        $hafalan = Hafalan::findOrFail($id);
        $hafalan->update([
            'santri_id' => $request->santri_id,
            'jenis' => $request->jenis,
            'nama_hafalan' => $request->nama_hafalan,
            'progress' => $request->progress,
            'tanggal' => $request->tanggal,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pendidikan.hafalan.index')->with('success', 'Data hafalan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $hafalan->delete();
        return redirect()->route('pendidikan.hafalan.index')->with('success', 'Data hafalan berhasil dihapus.');
    }

    // Kitab Talaran Configuration Methods
    public function updateKitabTalaran(Request $request, $kelasId)
    {
        $request->validate([
            'semester' => 'required|in:1,2',
            'nama_kitab' => 'required|string'
        ]);

        \App\Models\KitabTalaran::updateOrCreate(
            [
                'kelas_id' => $kelasId,
                'semester' => $request->semester
            ],
            [
                'nama_kitab' => $request->nama_kitab
            ]
        );

        return response()->json(['success' => true]);
    }

    public function deleteKitabByKelas($kelasId)
    {
        \App\Models\KitabTalaran::where('kelas_id', $kelasId)->delete();
        return response()->json(['success' => true]);
    }

    private function getCurrentSemester()
    {
        // Simple logic: July-Dec = 1, Jan-June = 2
        return date('n') >= 7 ? 1 : 2;
    }
}
