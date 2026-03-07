<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Services\TelegramService;
use App\Services\FonnteService;
use App\Models\Santri;
use App\Models\Syahriah;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
{
    protected $midtransService;
    protected $telegramService;
    protected $fonnteService;

    public function __construct(MidtransService $midtrans, TelegramService $telegram, FonnteService $fonnte)
    {
        $this->midtransService = $midtrans;
        $this->telegramService = $telegram;
        $this->fonnteService = $fonnte;
    }

    /**
     * Generate VA for a Santri
     */
    public function generateVa(Request $request, Santri $santri)
    {
        // Check if already has VA
        if ($santri->virtual_account_number) {
            return back()->with('error', 'Santri already has a Virtual Account.');
        }

        // Call Service
        $response = $this->midtransService->createTransaction($santri);

        if ($response && isset($response['va_numbers'][0]['va_number'])) {
            $vaNumber = $response['va_numbers'][0]['va_number'];

            // Update Santri
            $santri->update(['virtual_account_number' => $vaNumber]);

            return back()->with('success', 'Virtual Account berhasil di-generate: ' . $vaNumber);
        } else if ($response && isset($response['permata_va_number'])) {
            // Fallback for Permata
            $vaNumber = $response['permata_va_number'];
            $santri->update(['virtual_account_number' => $vaNumber]);
            return back()->with('success', 'Virtual Account berhasil di-generate: ' . $vaNumber);
        }

        return back()->with('error', 'Gagal generate VA dari Midtrans. Cek log atau pulsa/kuota API.');
    }

    /**
     * Reset VA (Clear VA Number) for a Santri
     */
    public function resetVa(Request $request, Santri $santri)
    {
        $santri->update(['virtual_account_number' => null]);
        return back()->with('success', 'Virtual Account berhasil di-reset. Silakan generate ulang untuk transaksi baru.');
    }

    /**
     * Bulk Generate VA for all Santri without VA
     */
    public function generateVaBulk(Request $request)
    {
        // Increase time limit for bulk process
        set_time_limit(300); // 5 minutes

        $santris = Santri::whereNull('virtual_account_number')
                         ->orWhere('virtual_account_number', '')
                         ->get();

        if ($santris->isEmpty()) {
            return back()->with('info', 'Semua santri sudah memiliki Virtual Account.');
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($santris as $santri) {
            try {
                // Determine nominal (using default)
                $response = $this->midtransService->createTransaction($santri);

                if ($response && isset($response['va_numbers'][0]['va_number'])) {
                    DB::transaction(function () use ($santri, $response) {
                        $santri->update(['virtual_account_number' => $response['va_numbers'][0]['va_number']]);
                    });
                    $successCount++;
                } else if ($response && isset($response['permata_va_number'])) {
                    DB::transaction(function () use ($santri, $response) {
                        $santri->update(['virtual_account_number' => $response['permata_va_number']]);
                    });
                    $successCount++;
                } else {
                    $failCount++;
                }

                // Optional: Sleep to prevent rate rate limit if needed
                // sleep(1);
            } catch (\Exception $e) {
                Log::error("Bulk VA Error for ID {$santri->id}: " . $e->getMessage());
                $failCount++;
            }
        }

        return back()->with('success', "Proses Selesai. Sukses: $successCount, Gagal: $failCount");
    }

    /**
     * Bulk Reset VA (Clear All VA Numbers)
     */
    public function resetVaBulk(Request $request)
    {
        // Update all santri set va to null
        Santri::query()->update(['virtual_account_number' => null]);

        return back()->with('success', 'Semua Virtual Account berhasil di-reset (dihapus). Silakan generate ulang massal jika diperlukan.');
    }

    /**
     * Handle incoming Webhook from Midtrans
     */
    public function webhook(Request $request)
    {
        Log::info('Midtrans Webhook Received:', $request->all());

        $notification = $request->all();
        $orderId = $notification['order_id'];
        $statusCode = $notification['status_code'];
        $grossAmount = $notification['gross_amount'];
        $signatureKey = $notification['signature_key'];
        $transactionStatus = $notification['transaction_status'];
        $type = $notification['payment_type'];
        $fraudStatus = $notification['fraud_status'] ?? null;

        // 1. Verify Signature
        if (!$this->midtransService->isValidSignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning("Midtrans Invalid Signature: $orderId");
            return response()->json(['message' => 'Invalid Signature'], 400);
        }

        // 2. Idempotency check — cegah double processing webhook
        $existingLog = DB::table('payment_gateway')->where('order_id', $orderId)->first();
        if ($existingLog && $existingLog->transaction_status === $transactionStatus) {
            Log::info("Midtrans Webhook duplicate ignored: $orderId (status: $transactionStatus)");
            return response()->json(['message' => 'Already processed']);
        }

        // 3. Wrap semua operasi database dalam transaksi
        $notificationData = null; // Data untuk notifikasi setelah commit

        try {
            $notificationData = DB::transaction(function () use (
                $orderId, $statusCode, $grossAmount, $signatureKey,
                $transactionStatus, $type, $fraudStatus, $notification
            ) {
                // Extract NIS from Order ID (Format: SPP-NIS-TIMESTAMP)
                $parts = explode('-', $orderId);
                $nis = isset($parts[1]) ? $parts[1] : null;

                // Store/update payment log
                DB::table('payment_gateway')->updateOrInsert(
                    ['order_id' => $orderId],
                    [
                        'payment_type' => $type,
                        'transaction_status' => $transactionStatus,
                        'gross_amount' => $grossAmount,
                        'json_response' => json_encode($notification),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Process Status
                if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
                    return $this->handleSuccess($nis, $grossAmount);
                } else if ($transactionStatus == 'settlement') {
                    return $this->handleSuccess($nis, $grossAmount);
                }

                return null;
            });
        } catch (\Exception $e) {
            Log::error("Midtrans Webhook Transaction Failed: {$orderId} - " . $e->getMessage());
            return response()->json(['message' => 'Processing error'], 500);
        }

        // 4. Kirim notifikasi SETELAH commit (di luar transaksi)
        if ($notificationData) {
            $this->sendPaymentNotifications($notificationData);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Handle successful payment — HARUS dipanggil di dalam DB::transaction
     * Menggunakan lockForUpdate() untuk mencegah race condition
     *
     * @return array|null Data notifikasi untuk dikirim setelah commit
     */
    private function handleSuccess($nis, $amount)
    {
        if (!$nis) return null;

        $santri = Santri::where('nis', $nis)->first();
        if (!$santri) return null;

        $adminGroupId = env('FONNTE_ADMIN_GROUP_ID');

        // SMART PAYMENT LOGIC: Find oldest unpaid month WITH LOCKING
        $unpaidMonth = Syahriah::where('santri_id', $santri->id)
            ->where('is_lunas', false)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->lockForUpdate()
            ->first();

        if ($unpaidMonth) {
            // Mark as Paid (atomic within transaction)
            $unpaidMonth->update([
                'is_lunas' => true,
                'tanggal_bayar' => now(),
                'keterangan' => 'Lunas via Midtrans (Auto)',
                'nominal' => $amount
            ]);

            $monthName = \Carbon\Carbon::create()->month($unpaidMonth->bulan)->translatedFormat('F');
            $year = $unpaidMonth->tahun;

            $remainingArrearsCount = Syahriah::where('santri_id', $santri->id)->where('is_lunas', false)->count();
            $arrearsInfo = $remainingArrearsCount > 0
                ? "⚠️ Masih ada tunggakan $remainingArrearsCount bulan lagi."
                : "✅ Alhamdulillah lunas, tidak ada tunggakan.";

            Log::info("Payment Processed for Santri $nis - Month $monthName $year");

            // Return data untuk notifikasi (dikirim SETELAH commit)
            return [
                'type' => 'payment',
                'santri' => $santri,
                'amount' => $amount,
                'month_name' => $monthName,
                'year' => $year,
                'arrears_info' => $arrearsInfo,
                'admin_group_id' => $adminGroupId,
                'label' => 'LUNAS',
            ];

        } else {
            // ADVANCE PAYMENT
            $lastBill = Syahriah::where('santri_id', $santri->id)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->lockForUpdate()
                ->first();

            $nextMonth = 1;
            $nextYear = date('Y');

            if ($lastBill) {
                $nextMonth = $lastBill->bulan + 1;
                $nextYear = $lastBill->tahun;
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
            } else {
                $nextMonth = date('n');
            }

            Syahriah::create([
                'santri_id' => $santri->id,
                'bulan' => $nextMonth,
                'tahun' => $nextYear,
                'nominal' => $amount,
                'is_lunas' => true,
                'tanggal_bayar' => now(),
                'keterangan' => 'Lunas via Midtrans (Advance)',
            ]);

            $monthName = \Carbon\Carbon::create()->month($nextMonth)->translatedFormat('F');

            Log::info("Advance Payment for Santri $nis - $monthName $nextYear");

            return [
                'type' => 'advance',
                'santri' => $santri,
                'amount' => $amount,
                'month_name' => $monthName,
                'year' => $nextYear,
                'arrears_info' => "🌟 Dialokasikan untuk bulan depan (Advance).",
                'admin_group_id' => $adminGroupId,
                'label' => 'ADVANCE / DEPOSIT',
            ];
        }
    }

    /**
     * Kirim notifikasi pembayaran — dipanggil SETELAH DB::commit
     * Kegagalan notifikasi tidak akan merusak data keuangan
     */
    private function sendPaymentNotifications(array $data)
    {
        try {
            $santri = $data['santri'];
            $prefix = $data['type'] === 'advance' ? '🌟 PEMBAYARAN DEPOSIT (ADVANCE)' : '✅ PEMBAYARAN DITERIMA';
            $bulanLabel = $data['type'] === 'advance' ? 'Alokasi' : 'Bulan';

            // 1. TELEGRAM
            $telegramMsg = "{$prefix}\n\n";
            $telegramMsg .= "Santri: {$santri->nama_santri}\n";
            $telegramMsg .= "{$bulanLabel}: {$data['month_name']} {$data['year']}\n";
            $telegramMsg .= "Nominal: Rp " . number_format($data['amount'], 0, ',', '.') . "\n";
            $this->telegramService->sendMessage($telegramMsg);

            // 2. WHATSAPP (Parent)
            if ($santri->no_hp_ortu_wali) {
                $this->fonnteService->notifyPaymentSuccess(
                    $santri->no_hp_ortu_wali,
                    $santri->nama_santri,
                    $data['amount'],
                    $data['month_name'],
                    $data['year'],
                    $data['arrears_info']
                );
            }

            // 3. WHATSAPP (Admin Group)
            if ($data['admin_group_id']) {
                $this->fonnteService->notifyAdminReport(
                    $data['admin_group_id'],
                    $santri->nama_santri,
                    $data['amount'],
                    $data['month_name'],
                    $data['year'],
                    $data['label']
                );
            }
        } catch (\Exception $e) {
            Log::warning('Payment notification failed (data already saved): ' . $e->getMessage());
        }
    }
}
