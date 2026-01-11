<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Syahriah;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /**
     * Get list of santri with arrears (targets for billing)
     */
    public function getTargets()
    {
        $santris = Santri::where('is_active', true)
            ->whereNotNull('no_hp_ortu_wali')
            ->where('no_hp_ortu_wali', '!=', '')
            ->get();

        $targets = [];

        foreach ($santris as $santri) {
            // Calculate Arrears
            $unpaidBills = Syahriah::where('santri_id', $santri->id)
                ->where('is_lunas', false)
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->get();

            if ($unpaidBills->isEmpty()) {
                continue;
            }

            $totalArrears = $unpaidBills->sum('nominal');
            $countMonths = $unpaidBills->count();
            
            // Format message details
            $details = $unpaidBills->take(3)->map(function($bill) {
                $monthName = \Carbon\Carbon::create()->month($bill->bulan)->translatedFormat('F');
                return "$monthName {$bill->tahun}";
            })->implode(', ');

            if ($countMonths > 3) {
                $details .= " dan " . ($countMonths - 3) . " bulan lainnya.";
            }

            $targets[] = [
                'id' => $santri->id,
                'nama' => $santri->nama_santri,
                'phone' => $santri->no_hp_ortu_wali,
                'tunggakan' => $totalArrears,
                'bulan_count' => $countMonths,
                'details' => $details
            ];
        }

        return response()->json([
            'count' => count($targets),
            'targets' => $targets
        ]);
    }

    /**
     * Send reminder to a single target
     */
    public function sendSingleReminder(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'nama' => 'required',
            'tunggakan' => 'required',
            'details' => 'required'
        ]);

        $phone = $request->phone;
        $nama = $request->nama;
        $tunggakan = number_format($request->tunggakan, 0, ',', '.');
        $details = $request->details;

        $message = "⚠️ *TAGIHAN SYAHRIAH / SPP*\n\n";
        $message .= "Yth. Wali Santri dari *$nama*,\n\n";
        $message .= "Kami informasikan bahwa terdapat tunggakan Syahriah:\n";
        $message .= "💰 Total: *Rp $tunggakan*\n";
        $message .= "📅 Rincian: $details\n\n";
        $message .= "Mohon segera melakukan pembayaran. Abaikan jika sudah membayar.\n";
        $message .= "_Sistem Informasi Riyadlul Huda_";

        $status = $this->fonnteService->sendMessage($phone, $message);

        return response()->json([
            'success' => $status,
            'message' => $status ? 'Terkirim' : 'Gagal Kirim'
        ]);
    }
}
