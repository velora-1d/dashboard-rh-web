<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerizinanController extends Controller
{
    public function index()
    {
        $perizinan = Perizinan::with('santri')->orderBy('created_at', 'desc')->paginate(10);
        return view('sekretaris.perizinan.index', compact('perizinan'));
    }

    public function approval(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update([
            'status' => $request->status,
            'approved_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Status perizinan berhasil diperbarui.');
    }
}
