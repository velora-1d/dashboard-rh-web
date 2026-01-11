<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;
    protected $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    /**
     * Send WhatsApp message to a specific number or comma-separated numbers (group/multiple)
     * 
     * @param string $target Phone number (e.g., '08123456789' or '628123456789')
     * @param string $message The message content
     * @return bool
     */
    public function sendMessage(string $target, string $message): bool
    {
        if (!$this->token) {
            Log::warning('Fonnte token not set. Message not sent.');
            return false;
        }

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => $this->token,
                ])
                ->post($this->apiUrl, [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62', // Default to Indonesia
                ]);

            if ($response->successful()) {
                Log::info("Fonnte message sent to {$target}");
                return true;
            }

            Log::error('Fonnte API Error: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send payment notification to parent (Format: Kuitansi Resmi - Sopan)
     */
    public function notifyPaymentSuccess($targetPhone, $santriName, $amount, $monthName, $year, $arrearsInfo = null)
    {
        $formattedAmount = number_format($amount, 0, ',', '.');
        
        $message = "🏛️ BUKTI PEMBAYARAN SYAHRIAH\n\n";
        $message .= "Terima kasih, pembayaran Syahriah telah kami terima.\n\n";
        $message .= "👤 Data Santri\n";
        $message .= "Nama   : $santriName\n";
        // $message .= "Kelas  : [Kelas]\n"; // Optional if data passed
        
        $message .= "\n💰 Rincian Pembayaran\n";
        $message .= "Bulan  : $monthName $year\n";
        $message .= "Jumlah : Rp $formattedAmount\n";
        $message .= "Status : ✅ LUNAS\n\n";
        
        if ($arrearsInfo) {
            $message .= "ℹ️ Info Tagihan\n";
            $message .= "$arrearsInfo\n\n";
        }
        
        $message .= "_Semoga rezeki Bapak/Ibu semakin berkah. Aamiin._\n";
        $message .= "📅 " . date('d-m-Y H:i');

        return $this->sendMessage($targetPhone, $message);
    }

    /**
     * Send payment report to Admin Group (Format: Laporan Tegas - To The Point)
     */
    public function notifyAdminReport($targetGroup, $santriName, $amount, $monthName, $year, $status = 'LUNAS')
    {
        $formattedAmount = number_format($amount, 0, ',', '.');
        
        $message = "📥 LAPORAN PEMBAYARAN SYAHRIAH\n\n";
        $message .= "Telah diterima pembayaran dari:\n";
        $message .= "👤 $santriName\n";
        // $message .= "🏠 [Kelas] - [Asrama]\n";
        
        $message .= "\n💰 Rp $formattedAmount\n";
        $message .= "📅 Alokasi: $monthName $year\n";
        $message .= "✓ Status: $status\n\n";
        
        $message .= "Via: Midtrans Virtual Account\n";
        $message .= "⏰ " . date('d-m-Y H:i');

        return $this->sendMessage($targetGroup, $message);
    }

    /**
     * Send Income Report to Admin Group
     */
    public function notifyIncome($targetGroup, $source, $category, $amount, $date, $description, $user)
    {
        $formattedAmount = number_format($amount, 0, ',', '.');
        $formattedDate = date('d-m-Y', strtotime($date));
        
        $message = "📥 LAPORAN PEMASUKAN UMUM\n\n";
        $message .= "Sumber  : $source\n";
        $message .= "Kategori: $category\n\n";
        
        $message .= "💰 Rp $formattedAmount\n";
        $message .= "📅 Tanggal: $formattedDate\n";
        $message .= "📝 Ket: $description\n\n";
        
        $message .= "Catatan: Diinput oleh $user\n";
        $message .= "⏰ " . date('d-m-Y H:i');

        return $this->sendMessage($targetGroup, $message);
    }

    /**
     * Send Expense Report to Admin Group
     */
    public function notifyExpense($targetGroup, $type, $category, $amount, $date, $description, $user)
    {
        $formattedAmount = number_format($amount, 0, ',', '.');
        $formattedDate = date('d-m-Y', strtotime($date));
        
        $message = "📤 LAPORAN PENGELUARAN\n\n";
        $message .= "Jenis   : $type\n";
        $message .= "Kategori: $category\n\n";
        
        $message .= "💸 Rp $formattedAmount\n";
        $message .= "📅 Tanggal: $formattedDate\n";
        $message .= "📝 Ket: $description\n\n";
        
        $message .= "Catatan: Diinput oleh $user\n";
        $message .= "⏰ " . date('d-m-Y H:i');

        return $this->sendMessage($targetGroup, $message);
    }

    /**
     * Send generic notification
     */
    public function notify($target, $title, $body)
    {
        $message = "📢 $title\n\n$body";
        return $this->sendMessage($target, $message);
    }
}
