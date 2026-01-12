<?php

namespace App\Services;

use App\Models\Syahriah;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\GajiPegawai;
use App\Models\Santri;
use Illuminate\Support\Carbon;

class FinancialService
{
    /**
     * Calculate comprehensive dashboard statistics
     */
    public function getDashboardStats($year, $month = null)
    {
        // 1. Pemasukan (General)
        $queryPemasukan = Pemasukan::whereYear('tanggal', $year);
        if ($month) $queryPemasukan->whereMonth('tanggal', $month);
        $totalPemasukan = $queryPemasukan->sum('nominal');

        // 2. Pengeluaran
        $queryPengeluaran = Pengeluaran::whereYear('tanggal', $year);
        if ($month) $queryPengeluaran->whereMonth('tanggal', $month);
        $totalPengeluaran = $queryPengeluaran->sum('nominal');

        // 3. Syahriah (SPP)
        $querySyahriah = Syahriah::where('tahun', $year)->where('is_lunas', true);
        if ($month) $querySyahriah->where('bulan', $month);
        
        // Split Manual vs Gateway
        $syahriahManual = (clone $querySyahriah)
            ->where(function($q) {
                $q->whereNull('keterangan')
                  ->orWhere('keterangan', 'not like', '%Midtrans%');
            })->sum('nominal');

        $syahriahGateway = (clone $querySyahriah)
            ->where('keterangan', 'like', '%Midtrans%')
            ->sum('nominal');

        $totalSyahriah = $syahriahManual + $syahriahGateway;

        // 4. Saldo Calculation
        $saldoTotal = ($totalPemasukan + $totalSyahriah) - $totalPengeluaran;

        return [
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'syahriah_manual' => $syahriahManual,
            'syahriah_gateway' => $syahriahGateway,
            'total_syahriah' => $totalSyahriah,
            'saldo' => $saldoTotal,
            'year' => $year,
            'month' => $month
        ];
    }

    /**
     * Calculate Arrears (Tunggakan) for Santri
     * Improved optimized version (No N+1)
     */
    public function calculateTunggakan($santriId = null, $biayaBulanan = 500000)
    {
        $endDate = Carbon::now();
        $query = Santri::where('is_active', true);
        if ($santriId) {
            $query->where('id', $santriId);
        }
        
        $allSantri = $query->select('id', 'tanggal_masuk', 'created_at', 'nama_santri', 'nis', 'no_hp_ortu_wali', 'kelas_id', 'asrama_id')
            ->with(['kelas', 'asrama'])
            ->get();

        // Fetch all paid syahriah for these santri in one go
        $allSyahriah = Syahriah::whereIn('santri_id', $allSantri->pluck('id'))
            ->where('is_lunas', true)
            ->select('santri_id', 'bulan', 'tahun')
            ->get()
            ->groupBy('santri_id');

        $totalTunggakanValue = 0;
        $totalSantriMenunggakCount = 0;
        $details = [];

        foreach ($allSantri as $santri) {
            $startDate = $santri->tanggal_masuk ?? $santri->created_at;
            $current = Carbon::parse($startDate)->startOfMonth();
            
            $santriPaidMonths = isset($allSyahriah[$santri->id]) 
                ? $allSyahriah[$santri->id]->map(fn($item) => $item->bulan . '-' . $item->tahun)->toArray()
                : [];
            
            $unpaidMonths = [];
            while ($current <= $endDate) {
                $monthKey = $current->month . '-' . $current->year;
                if (!in_array($monthKey, $santriPaidMonths)) {
                    $unpaidMonths[] = [
                        'raw' => $monthKey,
                        'formatted' => $current->translatedFormat('F Y')
                    ];
                }
                $current->addMonth();
            }

            if (count($unpaidMonths) > 0) {
                $nominalTunggakan = count($unpaidMonths) * $biayaBulanan;
                $totalTunggakanValue += $nominalTunggakan;
                $totalSantriMenunggakCount++;
                
                $details[] = [
                    'santri' => $santri,
                    'months' => $unpaidMonths,
                    'total_months' => count($unpaidMonths),
                    'total_amount' => $nominalTunggakan
                ];
            }
        }

        return [
            'total_arrears' => $totalTunggakanValue,
            'student_count' => $totalSantriMenunggakCount,
            'details' => $details
        ];
    }

    /**
     * Get Monthly Cashflow Chart Data
     */
    public function getCashFlowChart($year)
    {
        $months = range(1, 12);
        $data = [
            'pemasukan' => [],
            'pengeluaran' => []
        ];

        // Efficient Aggregation
        $pemasukanData = Pemasukan::whereYear('tanggal', $year)
            ->selectRaw('MONTH(tanggal) as month, SUM(nominal) as total') // Check column name 'nominal' or 'jumlah'
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        // Syahriah is also income
        $syahriahData = Syahriah::whereYear('created_at', $year) // Assuming date based on payment date? No, Syahriah has 'tahun' column but date is better for cashflow
            ->where('is_lunas', true)
            ->where('tahun', $year) // Let's stick to the 'tahun' column for consistency with dashboard
            ->selectRaw('bulan as month, SUM(nominal) as total')
            ->groupBy('bulan')
            ->pluck('total', 'month')
            ->toArray();

        $pengeluaranData = Pengeluaran::whereYear('tanggal', $year)
            ->selectRaw('MONTH(tanggal) as month, SUM(nominal) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $gajiData = GajiPegawai::where('tahun', $year)
            ->where('is_dibayar', true)
            ->selectRaw('bulan as month, SUM(nominal) as total')
            ->groupBy('bulan')
            ->pluck('total', 'month')
            ->toArray();

        foreach ($months as $m) {
            // Total Income = Pemasukan + Syahriah
            $inc = ($pemasukanData[$m] ?? 0) + ($syahriahData[$m] ?? 0);
            
            // Total Expense = Pengeluaran + Gaji
            $exp = ($pengeluaranData[$m] ?? 0) + ($gajiData[$m] ?? 0);

            $data['pemasukan'][] = $inc;
            $data['pengeluaran'][] = $exp;
        }

        return $data;
    }
}
