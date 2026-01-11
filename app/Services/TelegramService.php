<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    /**
     * Send a text message to Telegram
     */
    public function sendMessage(string $message, ?string $chatId = null): bool
    {
        if (!$this->botToken) {
            Log::warning('Telegram bot token not configured');
            return false;
        }

        $targetChatId = $chatId ?? $this->chatId;

        if (!$targetChatId) {
            Log::warning('Telegram chat ID not configured');
            return false;
        }

        try {
            // Note: withoutVerifying() is used for Windows development environments
            // Remove in production with proper SSL certificates
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withoutVerifying()->post("{$this->apiUrl}/sendMessage", [
                'chat_id' => $targetChatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->successful()) {
                Log::info('Telegram message sent successfully');
                return true;
            }

            Log::error('Telegram API error: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Telegram send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification for new santri registration
     */
    public function notifySantriRegistration(array $santri): bool
    {
        $message = "🆕 <b>SANTRI BARU TERDAFTAR</b>\n\n";
        $message .= "📛 Nama: <b>{$santri['nama']}</b>\n";
        $message .= "👤 Jenis Kelamin: {$santri['jenis_kelamin']}\n";
        $message .= "🏫 Kelas: {$santri['kelas']}\n";
        $message .= "🏠 Asrama: {$santri['asrama']}\n";
        $message .= "📅 Tanggal: " . now()->format('d M Y H:i');

        return $this->sendMessage($message);
    }

    /**
     * Send notification for payment received
     */
    public function notifyPaymentReceived(array $payment): bool
    {
        $amount = number_format($payment['jumlah'], 0, ',', '.');
        $sisaTunggakan = isset($payment['sisa_tunggakan']) ? number_format($payment['sisa_tunggakan'], 0, ',', '.') : '0';
        
        $message = "💰 <b>PEMBAYARAN DITERIMA</b>\n\n";
        $message .= "📛 Santri: <b>{$payment['nama_santri']}</b>\n";
        $message .= "👤 Gender: {$payment['gender']}\n";
        $message .= "🏫 Kelas: {$payment['kelas']}\n";
        $message .= "🏠 Asrama: {$payment['asrama']}\n";
        $message .= "💵 Jumlah: Rp {$amount}\n";
        $message .= "📝 Keterangan: {$payment['keterangan']}\n";
        $message .= "💳 Sisa Tunggakan: Rp {$sisaTunggakan}\n";
        $message .= "📅 Tanggal: " . now()->format('d M Y H:i');

        return $this->sendMessage($message);
    }

    /**
     * Send notification for arrears warning
     */
    public function notifyArrearsWarning(array $santriList): bool
    {
        $message = "⚠️ <b>PERINGATAN TUNGGAKAN SPP</b>\n\n";
        $message .= "Berikut santri dengan tunggakan:\n\n";

        foreach (array_slice($santriList, 0, 10) as $idx => $santri) {
            $amount = number_format($santri['tunggakan'], 0, ',', '.');
            $message .= ($idx + 1) . ". {$santri['nama']} - Rp {$amount}\n";
        }

        if (count($santriList) > 10) {
            $remaining = count($santriList) - 10;
            $message .= "\n...dan {$remaining} santri lainnya.";
        }

        $totalTunggakan = array_sum(array_column($santriList, 'tunggakan'));
        $message .= "\n\n💰 <b>Total Tunggakan: Rp " . number_format($totalTunggakan, 0, ',', '.') . "</b>";

        return $this->sendMessage($message);
    }

    /**
     * Send notification for daily backup
     */
    public function notifyBackupSuccess(string $filename, float $sizeKb): bool
    {
        $message = "✅ <b>BACKUP DATABASE BERHASIL</b>\n\n";
        $message .= "📁 File: {$filename}\n";
        $message .= "📦 Ukuran: {$sizeKb} KB\n";
        $message .= "📅 Waktu: " . now()->format('d M Y H:i:s');

        return $this->sendMessage($message);
    }

    /**
     * Send notification for grade input completion
     */
    public function notifyGradeInputComplete(string $kelas, string $mapel, int $count): bool
    {
        $message = "📝 <b>INPUT NILAI SELESAI</b>\n\n";
        $message .= "🏫 Kelas: {$kelas}\n";
        $message .= "📚 Mata Pelajaran: {$mapel}\n";
        $message .= "👥 Jumlah Santri: {$count}\n";
        $message .= "📅 Waktu: " . now()->format('d M Y H:i');

        return $this->sendMessage($message);
    }

    /**
     * Send custom notification
     */
    public function notify(string $title, string $body, string $icon = '📢'): bool
    {
        $message = "{$icon} <b>{$title}</b>\n\n{$body}";
        return $this->sendMessage($message);
    }
}
