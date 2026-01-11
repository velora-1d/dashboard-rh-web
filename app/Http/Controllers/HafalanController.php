<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanController extends Controller
{
    public function index()
    {
        $hafalan = Hafalan::with('santri')->orderBy('tanggal', 'desc')->paginate(10);
        return view('pendidikan.hafalan.index', compact('hafalan'));
    }

    public function create()
    {
        $santri = Santri::all();
        return view('pendidikan.hafalan.create', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string',
            'progress' => 'required|string',
            'tanggal' => 'required|date',
        ]);

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
}
