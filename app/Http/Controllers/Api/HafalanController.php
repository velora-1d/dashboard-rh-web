<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hafalan;

class HafalanController extends Controller
{
    // List History Hafalan (Untuk Wali Santri & Pendidikan)
    public function index(Request $request)
    {
        $request->validate(['santri_id' => 'required|exists:santri,id']);

        $query = Hafalan::where('santri_id', $request->santri_id);

        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        return response()->json(['data' => $data]);
    }

    // Input Hafalan (Untuk Bagian Pendidikan via Mobile/Web)
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jenis' => 'required|in:Quran,Kitab',
            'nama_hafalan' => 'required|string', // e.g., "Juz 30"
            'progress' => 'required|string',     // e.g., "An-Naba 1-10"
            'tanggal' => 'required|date',
            'nilai' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $hafalan = Hafalan::create([
            'santri_id' => $request->santri_id,
            'jenis' => $request->jenis,
            'nama_hafalan' => $request->nama_hafalan,
            'progress' => $request->progress,
            'tanggal' => $request->tanggal,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'created_by' => $request->user() ? $request->user()->id : null
        ]);

        return response()->json([
            'message' => 'Data hafalan berhasil disimpan',
            'data' => $hafalan
        ], 201);
    }
}
