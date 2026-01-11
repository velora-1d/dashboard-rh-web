<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerizinanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perizinan::with('santri')->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_mulai', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $perizinan = $query->paginate(10);
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

    public function destroy($id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->delete();
        return redirect()->back()->with('success', 'Data perizinan berhasil dihapus.');
    }
}
