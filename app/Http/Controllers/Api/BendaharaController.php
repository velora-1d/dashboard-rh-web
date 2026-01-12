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
    protected $financialService;

    public function __construct(\App\Services\FinancialService $financialService)
    {
        $this->financialService = $financialService;
    }

    public function dashboard(Request $request)
    {
        $today = Carbon::today();
        $year = $request->input('year', $today->year);
        $month = $request->input('month');

        // Use Service
        $stats = $this->financialService->getDashboardStats($year, $month);

        $pemasukanHariIni = Pemasukan::whereDate('tanggal', $today)->sum('jumlah') + 
                            Syahriah::where('is_lunas', true)->whereDate('tanggal_bayar', $today)->sum('nominal');
        
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', $today)->sum('jumlah');

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo_total' => $stats['saldo'],
                'arus_kas_hari_ini' => [
                    'masuk' => $pemasukanHariIni,
                    'keluar' => $pengeluaranHariIni
                ],
                'syahriah_summary' => [
                    'manual' => $stats['syahriah_manual'],
                    'gateway' => $stats['syahriah_gateway']
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
        
        // Use simplified query first to get IDs if searching
        $santriId = null;
        if ($search) {
             // If searching, we pass relevant IDs or handle logic in Service?
             // Service takes santriCount. Let's filter Santri first then loop via Service or
             // better, let's keep the lightweight search here and call Service's logic?
             // Actually, the Service's calculateTunggakan is heavy if we pass ALL santri.
             // But we need to filter by name first.
             // Let's refactor: Get Candidate Santris -> Call Service for them?
             // The Service `calculateTunggakan` currently fetches all active santri unless ID is passed.
             // We'll modify this loop here to be lighter or rely on Service logic if appropriate.
             // Since Service handles calculation logic (unpaid months), we can reuse that part.
             
             // BUT, for Mobile "Check Tunggakan", we just need the calculation logic.
             // The loop in Service returns an array.
             // Let's stick to the current logic which is efficient enough for search, but use the Service for the math.
        }
        
        // Re-implementing logic using Service would be cleaner.
        // Let's modify Service to accept a pre-filtered query or collection?
        // Or simply:
        
        $query = Santri::where('is_active', true);
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        // Pagination logic for mobile
        if (!$search) {
             $santriList = $query->take(20)->get(); // Default view
        } else {
             $santriList = $query->get();
        }
        
        $biayaBulanan = 500000;
        $endDate = Carbon::now();
        $result = [];

        // We can reuse the Service's logic if we extract "calculateSingleSantriTunggakan" or just duplicate the "Loop" part
        // but creating a service instance for 20 santris is fine.
        // Actually, for best performance, we should load Syahriah in BULK for these 20 items.
        
        // Let's replicate the BULK loading strategy here, but strictly tied to the retrieved $santriList IDs.
        
        $allSyahriah = Syahriah::whereIn('santri_id', $santriList->pluck('id'))
            ->where('is_lunas', true)
            ->select('santri_id', 'bulan', 'tahun')
            ->get()
            ->groupBy('santri_id');
            
        foreach ($santriList as $santri) {
            $startDate = $santri->tanggal_masuk ?? $santri->created_at;
            $current = Carbon::parse($startDate)->startOfMonth();
            
            $santriPaidMonths = isset($allSyahriah[$santri->id]) 
                ? $allSyahriah[$santri->id]->map(fn($item) => $item->bulan . '-' . $item->tahun)->toArray()
                : [];
            
            $unpaidMonthsList = [];
            while ($current <= $endDate) {
                $monthKey = $current->month . '-' . $current->year;
                if (!in_array($monthKey, $santriPaidMonths)) {
                    $unpaidMonthsList[] = $current->translatedFormat('F Y');
                }
                $current->addMonth();
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
                    'bulan_menunggak' => $unpaidMonthsList,
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

        $withdrawal = Withdrawal::create([
            'user_id' => Auth::id(),
            'bank_account_id' => $request->bank_account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Notify Admins via FCM & Database
        $admins = \App\Models\User::where('role', 'admin')->get();
        $fcm = new \App\Services\FcmService();
        
        foreach ($admins as $admin) {
            // FCM
            if ($admin->fcm_token) {
                $fcm->sendNotification(
                    $admin->fcm_token,
                    '💸 Pengajuan Penarikan Dana',
                    'Bendahara melakukan pengajuan penarikan dana sebesar Rp ' . number_format($request->amount, 0, ',', '.'),
                    ['type' => 'withdrawal', 'id' => $withdrawal->id]
                );
            }
            
            \App\Models\Notification::create([
                'type' => 'withdrawal',
                'title' => 'Pengajuan Penarikan Dana',
                'message' => 'Bendahara mengajukan penarikan Rp ' . number_format($request->amount, 0, ',', '.'),
                'role' => 'admin',
                'data' => ['withdrawal_id' => $withdrawal->id, 'user_id' => Auth::id()],
                'is_read' => false
            ]);
        }
        
        // WA Notification (Fonnte)
        if (class_exists(\App\Services\FonnteService::class)) {
            $fonnte = new \App\Services\FonnteService();
            
            // 1. Notify Specific Admin requested by User
            $targetNumber = '081320442174';
            $fonnte->notify($targetNumber, 'Pengajuan Penarikan Dana', 
                "Bendahara mengajukan penarikan sebesar Rp " . number_format($request->amount, 0, ',', '.') . 
                "\n\nCatatan: " . ($request->notes ?? '-') . 
                "\n\nMohon cek aplikasi untuk persetujuan."
            );

            // 2. Notify other admins found in DB
            foreach ($admins as $admin) {
                if ($admin->no_hp && $admin->no_hp !== $targetNumber) {
                    $fonnte->notify($admin->no_hp, 'Pengajuan Penarikan Dana', 
                        "Bendahara mengajukan penarikan sebesar Rp " . number_format($request->amount, 0, ',', '.') . 
                        "\n\nCatatan: " . ($request->notes ?? '-') . 
                        "\n\nMohon cek aplikasi untuk persetujuan."
                    );
                }
            }
        }

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

    public function updateGaji(Request $request, $id)
    {
        $gaji = GajiPegawai::findOrFail($id);
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

        $gaji->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data gaji berhasil diperbarui',
            'data' => $gaji
        ]);
    }

    public function destroyGaji($id)
    {
        $gaji = GajiPegawai::findOrFail($id);
        $gaji->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data gaji berhasil dihapus'
        ]);
    }

    // SYAHRIAH ACTIONS
    public function updateSyahriah(Request $request, $id)
    {
        $syahriah = Syahriah::findOrFail($id);
        
        $request->validate([
            'bulan' => 'required|string',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $syahriah->update([
            'bulan' => $request->bulan,
            'nominal' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data syahriah berhasil diperbarui',
            'data' => $syahriah
        ]);
    }

    public function destroySyahriah($id)
    {
        $syahriah = Syahriah::findOrFail($id);
        $syahriah->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data syahriah berhasil dihapus'
        ]);
    }

    // KAS ACTIONS
    public function updateKas(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string',
        ]);

        if ($request->type == 'pemasukan') {
            $record = Pemasukan::findOrFail($id);
        } else {
            $record = Pengeluaran::findOrFail($id);
        }

        $record->update([
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori ?? 'Umum',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kas berhasil diperbarui',
            'data' => $record
        ]);
    }

    public function destroyKas(Request $request, $id)
    {
        // Expect query param ?type=pemasukan or pengeluaran
        $type = $request->query('type');
        if (!$type) {
            return response()->json(['status' => 'error', 'message' => 'Type parameter required'], 400);
        }

        if ($type == 'pemasukan') {
            $record = Pemasukan::findOrFail($id);
        } else {
            $record = Pengeluaran::findOrFail($id);
        }

        $record->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data kas berhasil dihapus'
        ]);
    }

    // LAPORAN KEUANGAN SUMMARY
    // LAPORAN KEUANGAN SUMMARY
    public function getLaporanSummary(Request $request)
    {
        $year = $request->input('tahun', Carbon::now()->year);

        // 1. Get Stats from Service
        $stats = $this->financialService->getDashboardStats($year);
        
        // 2. Get Chart from Service
        $chartRaw = $this->financialService->getCashFlowChart($year);
        
        // Reformat chart data for Mobile API [ {bulan:1, masuk:X, keluar:Y}, ... ]
        $chartData = [];
        for ($i = 0; $i < 12; $i++) {
            $chartData[] = [
                'bulan' => $i + 1,
                'masuk' => $chartRaw['pemasukan'][$i],
                'keluar' => $chartRaw['pengeluaran'][$i]
            ];
        }

        // 3. Breakdown for Gaji & Others (Keeping generic since Service focuses on cashflow)
        // If we want exact breakdown like before, we can keep the specific Gaji logic here or add to Service.
        // For now, let's trust the Service's aggregation for totals, but Gaji detail might be needed.
        
        // We will stick to the basic totals from Service which are:
        // Pemasukan = Pemasukan + Syahriah
        // Pengeluaran = Pengeluaran + Gaji (Wait, Service's dashboard stats splits them differently?)
        
        // Check Service: 
        // getDashboardStats returns: total_pemasukan (Table Pemasukan), total_pengeluaran (Table Pengeluaran), total_syahriah.
        // It DOES NOT include Gaji in total_pengeluaran explicitly in the 'dashboard stats' return vs 'pemasukan' table query.
        // Let's check Service getCashFlowChart:
        // It DOES exp = pengeluaranData + gajiData.
        
        // So for the Summary below, we should match logic.
        
        // Re-query Gaji strictly for this report if needed, or update Service to return Gaji stats.
        // Let's add Gaji to the local query to be safe and precise.
        $gaji = GajiPegawai::where('tahun', $year)->get();
        $totalGaji = $gaji->sum('nominal');
        $terbayarGaji = $gaji->where('is_dibayar', true)->sum('nominal');
        
        $totalMasuk = $stats['total_pemasukan'] + $stats['total_syahriah'];
        $totalKeluar = $stats['total_pengeluaran'] + $terbayarGaji;
        $saldo = $totalMasuk - $totalKeluar;

        return response()->json([
            'status' => 'success',
            'data' => [
                'tahun' => $year,
                'summary' => [
                    'total_syahriah_potensi' => Syahriah::where('tahun', $year)->sum('nominal'), // Potensi is distinct from Realized
                    'total_syahriah_diterima' => $stats['total_syahriah'],
                    'total_pemasukan_lain' => $stats['total_pemasukan'],
                    'total_pengeluaran_operasional' => $stats['total_pengeluaran'],
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

    public function getLaporanUrl(Request $request)
    {
        $year = $request->input('tahun', Carbon::now()->year);

        // Verify request comes from authenticated Mobile App
        // Generate Temporary Signed URL
        $downloadUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'api.bendahara.download-laporan',
            now()->addMinutes(30),
            ['year' => $year]
        );

        return response()->json([
            'status' => 'success',
            'url' => $downloadUrl
        ]);
    }

    public function downloadLaporan(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        
        // Fetch Data reusing existing logic
        // We can just call the logic directly
        $stats = $this->financialService->getDashboardStats($year);
        $chartRaw = $this->financialService->getCashFlowChart($year);
        
        $chartData = [];
        for ($i = 0; $i < 12; $i++) {
            $chartData[] = [
                'bulan' => $i + 1,
                'masuk' => $chartRaw['pemasukan'][$i],
                'keluar' => $chartRaw['pengeluaran'][$i]
            ];
        }

        $gaji = GajiPegawai::where('tahun', $year)->get();
        $terbayarGaji = $gaji->where('is_dibayar', true)->sum('nominal');
        $totalMasuk = $stats['total_pemasukan'] + $stats['total_syahriah'];
        $totalKeluar = $stats['total_pengeluaran'] + $terbayarGaji;
        $saldo = $totalMasuk - $totalKeluar;

        $summary = [
            'total_masuk_bersih' => $totalMasuk,
            'total_keluar_bersih' => $totalKeluar,
            'saldo_akhir' => $saldo
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.laporan.laporan-keuangan-pdf', [
            'year' => $year,
            'summary' => $summary,
            'chart' => $chartData
        ]);

        return $pdf->download('Laporan-Keuangan-' . $year . '.pdf');
    }
}
