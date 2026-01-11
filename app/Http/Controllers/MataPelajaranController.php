<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with('kelas')->orderBy('nama_mapel');
        
        // Filter by search
        if ($request->filled('search')) {
            $query->where('nama_mapel', 'like', '%' . $request->search . '%');
        }
        
        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('kelas.id', $request->kelas);
            });
        }
        
        $mapel = $query->paginate(15)->withQueryString();
        $kelasList = \App\Models\Kelas::orderBy('nama_kelas')->get();
        
        return view('pendidikan.mata-pelajaran.index', compact('mapel', 'kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kategori' => 'required|string',
            'kkm' => 'required|numeric|min:0|max:100',
            'kelas_ids' => 'array'
        ]);

        // Create data array with default checks
        $data = $request->except('kelas_ids');
        $data['is_talaran'] = $request->has('is_talaran'); // Checkbox handling

        $mapel = MataPelajaran::create($data);
        
        if ($request->has('kelas_ids')) {
            $mapel->kelas()->attach($request->kelas_ids);
        }

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kategori' => 'required|string',
            'kkm' => 'required|numeric|min:0|max:100',
            'kelas_ids' => 'array'
        ]);

        $mapel = MataPelajaran::findOrFail($id);
        $data = $request->except('kelas_ids');
        $data['is_talaran'] = $request->has('is_talaran');

        $mapel->update($data);
        
        if ($request->has('kelas_ids')) {
            $mapel->kelas()->sync($request->kelas_ids);
        } else {
            $mapel->kelas()->detach();
        }

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil dihapus');
    }
}
