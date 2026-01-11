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
        
        $totalPemasukan = Pemasukan::sum('jumlah') + Syahriah::sum('jumlah_bayar');
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $pemasukanHariIni = Pemasukan::whereDate('tanggal', $today)->sum('jumlah') + 
                            Syahriah::whereDate('tanggal_bayar', $today)->sum('jumlah_bayar');
        
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', $today)->sum('jumlah');

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo_total' => $saldo,
                'arus_kas_hari_ini' => [
                    'masuk' => $pemasukanHariIni,
                    'keluar' => $pengeluaranHariIni
                ]
            ]
        ]);
    }

    public function kas(Request $request)
    {
        $type = $request->query('type', 'pemasukan'); // pemasukan or pengeluaran
        
        if ($type == 'pemasukan') {
            $data = Pemasukan::orderBy('tanggal', 'desc')->take(50)->get();
        } else {
            $data = Pengeluaran::orderBy('tanggal', 'desc')->take(50)->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'keterangan' => $item->keterangan,
                    'jumlah' => $item->jumlah,
                    'tanggal' => $item->tanggal,
                    'kategori' => $item->kategori ?? 'Umum',
                ];
            })
        ]);
    }

    public function cekTunggakan(Request $request)
    {
        $query = Santri::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
        }

        $santri = $query->with(['kelas'])->take(20)->get();

        return response()->json([
            'status' => 'success',
            'data' => $santri
        ]);
    }

    public function storeKas(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string',
        ]);

        if ($request->type == 'pemasukan') {
            $record = Pemasukan::create([
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tanggal' => $request->tanggal,
                'kategori' => $request->kategori ?? 'Umum',
            ]);
        } else {
            $record = Pengeluaran::create([
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tanggal' => $request->tanggal,
                'kategori' => $request->kategori ?? 'Umum',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Catatan keuangan berhasil disimpan',
            'data' => $record
        ]);
    }
}


