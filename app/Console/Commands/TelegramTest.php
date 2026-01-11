<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramService;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class TelegramTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:test {message? : Custom message to send}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Telegram notification integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Testing Telegram notification...');
        
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');
        
        $this->line("Bot Token: " . ($botToken ? substr($botToken, 0, 15) . '...' : 'NOT SET'));
        $this->line("Chat ID: " . ($chatId ?: 'NOT SET'));
        
        if (!$botToken || !$chatId) {
            $this->error('❌ Telegram not configured!');
            $this->newLine();
            $this->warn('Please set these in your .env file:');
            $this->line('  TELEGRAM_BOT_TOKEN=your_bot_token');
            $this->line('  TELEGRAM_CHAT_ID=your_chat_id');
            return SymfonyCommand::FAILURE;
        }
        
        // Direct API call for debugging
        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $message = "🎉 TEST NOTIFIKASI\n\n✅ Integrasi Telegram berhasil!\n📱 Sistem: Dashboard Riyadlul Huda\n🕐 Waktu: " . now()->format('d M Y H:i:s');
        
        try {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
            
            $this->line("HTTP Status: " . $response->status());
            $this->line("Response: " . $response->body());
            
            if ($response->successful()) {
                $this->info('✅ Message sent successfully!');
                return SymfonyCommand::SUCCESS;
            } else {
                $this->error('❌ API returned error');
                $body = $response->json();
                if (isset($body['description'])) {
                    $this->error('Error: ' . $body['description']);
                }
                return SymfonyCommand::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
            return SymfonyCommand::FAILURE;
        }
    }
}
