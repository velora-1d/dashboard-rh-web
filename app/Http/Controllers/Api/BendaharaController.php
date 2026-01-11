<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Syahriah;
use App\Models\Santri;
use App\Models\BankAccount;
use App\Models\Withdrawal;
use App\Models\GajiPegawai;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BendaharaController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = Carbon::today();
        $year = $request->input('year', $today->year);
        $month = $request->input('month');

        // Calculate totals based on Year/Month to match Web Dashboard logic
        $pemasukanQuery = Pemasukan::whereYear('tanggal', $year);
        $pengeluaranQuery = Pengeluaran::whereYear('tanggal', $year);
        $syahriahQuery = Syahriah::where('is_lunas', true)->where('tahun', $year);

        if ($month) {
            $pemasukanQuery->whereMonth('tanggal', $month);
            $pengeluaranQuery->whereMonth('tanggal', $month);
            $syahriahQuery->where('bulan', $month);
        }
        
        $totalPemasukan = $pemasukanQuery->sum('jumlah') + $syahriahQuery->sum('nominal');
        $totalPengeluaran = $pengeluaranQuery->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $pemasukanHariIni = Pemasukan::whereDate('tanggal', $today)->sum('jumlah') + 
                            Syahriah::where('is_lunas', true)->whereDate('tanggal_bayar', $today)->sum('nominal');
        
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', $today)->sum('jumlah');

        // Split syahriah into manual and gateway (Saved Year Filter)
        $syahriahManual = Syahriah::where('is_lunas', true)
            ->where('tahun', $year) // Match Web Logic
            ->where(function($q) {
                $q->whereNull('keterangan')
                  ->orWhere('keterangan', 'not like', '%Midtrans%');
            });

        $syahriahGateway = Syahriah::where('is_lunas', true)
            ->where('tahun', $year) // Match Web Logic
            ->where('keterangan', 'like', '%Midtrans%');
            
        if ($month) {
            $syahriahManual->where('bulan', $month);
            $syahriahGateway->where('bulan', $month);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo_total' => $saldo, // Now reflects "Saldo Tahun Ini" like Web
                'arus_kas_hari_ini' => [
                    'masuk' => $pemasukanHariIni,
                    'keluar' => $pengeluaranHariIni
                ],
                'syahriah_summary' => [
                    'manual' => $syahriahManual->sum('nominal'),
                    'gateway' => $syahriahGateway->sum('nominal')
                ],
                'filter' => [
                    'tahun' => $year,
                    'bulan' => $month
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
        $search = $request->search;
        
        $query = Santri::where('is_active', true)
            ->with(['kelas', 'asrama', 'syahriah' => function($q) {
                $q->where('is_lunas', true);
            }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        // Optimize: Only take 20 if search is empty, else take all matching search
        if (!$search) {
             $santriList = $query->take(20)->get();
        } else {
             $santriList = $query->get();
        }

        $biayaBulanan = 500000;
        $endDate = Carbon::now();
        $result = [];

        foreach ($santriList as $santri) {
            $startDate = $santri->tanggal_masuk ?? $santri->created_at;
            
            // Generate all months
            $allMonths = [];
            $current = Carbon::parse($startDate)->startOfMonth();
            while ($current <= $endDate) {
                $allMonths[] = $current->month . '-' . $current->year;
                $current->addMonth();
            }

            // Get paid months
            $paidMonths = $santri->syahriah
                ->map(fn($item) => $item->bulan . '-' . $item->tahun)
                ->toArray();

            // Calculate unpaid
            $unpaidMonthsList = [];
            foreach ($allMonths as $monthKey) {
                if (!in_array($monthKey, $paidMonths)) {
                    // Convert "5-2024" to "Mei 2024"
                    $parts = explode('-', $monthKey);
                    $dateObj = Carbon::createFromDate($parts[1], $parts[0], 1);
                    $unpaidMonthsList[] = $dateObj->translatedFormat('F Y');
                }
            }
            
            if (count($unpaidMonthsList) > 0) {
                $result[] = [
                    'id' => $santri->id,
                    'nis' => $santri->nis,
                    'nama_santri' => $santri->nama_santri,
                    'kelas' => $santri->kelas->nama_kelas ?? '-',
                    'asrama' => $santri->asrama->nama_asrama ?? '-',
                    'no_hp_ortu' => $santri->no_hp_ortu_wali,
                    'total_tunggakan' => count($unpaidMonthsList) * $biayaBulanan,
                    'bulan_menunggak' => $unpaidMonthsList, // Array of strings
                    'jumlah_bulan' => count($unpaidMonthsList)
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $result
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

    public function storeSyahriah(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'bulan' => 'required|string',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $syahriah = Syahriah::create([
            'santri_id' => $request->santri_id,
            'bulan' => $request->bulan,
            'tahun' => Carbon::now()->year, // Default current year
            'nominal' => $request->jumlah,
            'tanggal_bayar' => Carbon::now(),
            'is_lunas' => true,
            'keterangan' => $request->keterangan ?? 'Pembayaran Manual via Mobile',
        ]);

        // Notify Admins & Bendaharas (FCM)
        $santri = Santri::find($request->santri_id);
        $users = \App\Models\User::whereIn('role', ['admin', 'bendahara'])
            ->whereNotNull('fcm_token')
            ->where('id', '!=', Auth::id()) // Don't notify self
            ->get();
            
        $fcm = new \App\Services\FcmService();
        foreach ($users as $user) {
            $fcm->sendNotification(
                $user->fcm_token,
                '🏷️ Pembayaran Syahriah',
                "Pembayaran a.n {$santri->nama_santri} ({$request->bulan}) telah diterima sebesar Rp " . number_format($request->jumlah, 0, ',', '.'),
                ['type' => 'syahriah', 'id' => $syahriah->id]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran Syahriah berhasil dicatat',
            'data' => $syahriah
        ]);
    }

    // BANK ACCOUNTS
    public function getBankAccounts()
    {
        $accounts = BankAccount::where('is_active', true)->get();
        return response()->json(['status' => 'success', 'data' => $accounts]);
    }

    public function storeBankAccount(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
        ]);

        $account = BankAccount::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Rekening berhasil ditambahkan',
            'data' => $account
        ]);
    }

    // WITHDRAWALS
    public function getWithdrawals()
    {
        $withdrawals = Withdrawal::with(['bankAccount'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate Payment Gateway Balance
        $totalGatewayIncome = Syahriah::where('is_lunas', true)
            ->where('keterangan', 'like', '%Midtrans%')
            ->sum('nominal');

        $totalApprovedWithdrawals = Withdrawal::where('status', 'approved')->sum('amount');

        $saldoPaymentGateway = $totalGatewayIncome - $totalApprovedWithdrawals;
            
        return response()->json([
            'status' => 'success', 
            'data' => $withdrawals,
            'saldo_payment_gateway' => $saldoPaymentGateway
        ]);
    }

    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        // Optional: Check if balance enough (based on saldo currently)
        // But requested as just a "request" for admin to verify

        $withdrawal = Withdrawal::create([
            'user_id' => Auth::id(),
            'bank_account_id' => $request->bank_account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan penarikan berhasil dikirim',
            'data' => $withdrawal
        ]);
    }

    // PEGAWAI CRUD
    public function getPegawai(Request $request)
    {
        $query = Pegawai::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('departemen', 'like', "%{$search}%");
            });
        }

        $pegawai = $query->orderBy('nama_pegawai')->get();
        return response()->json(['status' => 'success', 'data' => $pegawai]);
    }

    public function storePegawai(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $pegawai = Pegawai::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil ditambahkan',
            'data' => $pegawai
        ]);
    }

    public function updatePegawai(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $pegawai->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil diperbarui',
            'data' => $pegawai
        ]);
    }

    public function destroyPegawai($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil dihapus'
        ]);
    }

    // GAJI CRUD
    public function getGaji(Request $request)
    {
        $query = GajiPegawai::with('pegawai');

        if ($request->has('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->has('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        $gaji = $query->latest()->get();

        return response()->json(['status' => 'success', 'data' => $gaji]);
    }

    public function storeGaji(Request $request)
    {
        $request->merge(['nominal' => str_replace('.', '', $request->nominal)]);
        
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'nominal' => 'required|numeric|min:0',
            'is_dibayar' => 'required|boolean',
            'tanggal_bayar' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $gaji = GajiPegawai::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data gaji berhasil ditambahkan',
            'data' => $gaji
        ]);
    }

    // LAPORAN KEUANGAN SUMMARY
    public function getLaporanSummary(Request $request)
    {
        $year = $request->input('tahun', Carbon::now()->year);

        // 1. Syahriah (SPP)
        $syahriah = Syahriah::where('tahun', $year)->get();
        $totalSyahriah = $syahriah->sum('nominal');
        $lunasSyahriah = $syahriah->where('is_lunas', true)->sum('nominal');

        // 2. Pemasukan (Umum)
        $pemasukan = Pemasukan::whereYear('tanggal', $year)->sum('jumlah');

        // 3. Pengeluaran
        $pengeluaran = Pengeluaran::whereYear('tanggal', $year)->sum('jumlah');

        // 4. Gaji
        $gaji = GajiPegawai::where('tahun', $year)->get();
        $totalGaji = $gaji->sum('nominal');
        $terbayarGaji = $gaji->where('is_dibayar', true)->sum('nominal');

        // Summary
        $totalMasuk = $lunasSyahriah + $pemasukan;
        $totalKeluar = $pengeluaran + $terbayarGaji;
        $saldo = $totalMasuk - $totalKeluar;

        // Monthly Data for Chart (Arus Kas)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthMasuk = Pemasukan::whereYear('tanggal', $year)->whereMonth('tanggal', $i)->sum('jumlah') + 
                         Syahriah::where('tahun', $year)->where('bulan', $i)->where('is_lunas', true)->sum('nominal');
            
            $monthKeluar = Pengeluaran::whereYear('tanggal', $year)->whereMonth('tanggal', $i)->sum('jumlah') +
                          GajiPegawai::where('tahun', $year)->where('bulan', $i)->where('is_dibayar', true)->sum('nominal');
            
            $chartData[] = [
                'bulan' => $i,
                'masuk' => $monthMasuk,
                'keluar' => $monthKeluar
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'tahun' => $year,
                'summary' => [
                    'total_syahriah_potensi' => $totalSyahriah,
                    'total_syahriah_diterima' => $lunasSyahriah,
                    'total_pemasukan_lain' => $pemasukan,
                    'total_pengeluaran_operasional' => $pengeluaran,
                    'total_gaji_potensi' => $totalGaji,
                    'total_gaji_dibayarkan' => $terbayarGaji,
                    'total_masuk_bersih' => $totalMasuk,
                    'total_keluar_bersih' => $totalKeluar,
                    'saldo_akhir' => $saldo
                ],
                'chart' => $chartData
            ]
        ]);
    }
}
