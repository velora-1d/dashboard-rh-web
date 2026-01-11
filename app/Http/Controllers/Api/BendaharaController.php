<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Syahriah;
use App\Models\Santri;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Statistik Saldo (Simplified for MVP, requires proper logic from Web Controller)
        $totalPemasukan = Pemasukan::sum('jumlah') + Syahriah::sum('jumlah_bayar');
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $pemasukanHariIni = Pemasukan::whereDate('tanggal', $today)->sum('jumlah') + 
                            Syahriah::whereDate('tanggal_bayar', $today)->sum('jumlah_bayar');
        
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', $today)->sum('jumlah');

        return response()->json([
            'saldo_total' => $saldo,
            'arus_kas_hari_ini' => [
                'masuk' => $pemasukanHariIni,
                'keluar' => $pengeluaranHariIni
            ]
        ]);
    }

    public function cekTunggakan(Request $request)
    {
        $query = Santri::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $santri = $query->with(['kelas'])->take(20)->get();
        // Note: Real tunggakan logic requires checking Syahriah table vs Months.
        // For MVP, returning santri list first.

        return response()->json([
            'data' => $santri
        ]);
    }
}
