<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KalenderPendidikan;
use App\Services\TelegramService;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class SendCalendarReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Telegram reminders for calendar events 2 days in advance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Checking for upcoming calendar events...');
        
        // Get events that start in 2 days
        $twoDaysFromNow = now()->addDays(2)->format('Y-m-d');
        
        $upcomingEvents = KalenderPendidikan::whereDate('tanggal_mulai', $twoDaysFromNow)->get();
        
        if ($upcomingEvents->isEmpty()) {
            $this->info('No events in 2 days.');
            return SymfonyCommand::SUCCESS;
        }
        
        $telegram = new TelegramService();
        
        $kategoriIcon = [
            'Libur' => '🏖️',
            'Ujian' => '📝',
            'Kegiatan' => '🎯',
            'Rapat' => '👥',
            'Lainnya' => '📅'
        ];
        
        foreach ($upcomingEvents as $event) {
            try {
                $tanggal = $event->tanggal_mulai->format('d M Y');
                if ($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai) {
                    $tanggal .= ' - ' . $event->tanggal_selesai->format('d M Y');
                }
                
                $icon = $kategoriIcon[$event->kategori] ?? '📅';
                
                $telegram->notify(
                    '⏰ PENGINGAT - 2 HARI LAGI',
                    "📌 {$event->judul}\n" .
                    "{$icon} Kategori: {$event->kategori}\n" .
                    "📅 Tanggal: {$tanggal}" .
                    ($event->deskripsi ? "\n📝 {$event->deskripsi}" : ""),
                    '🔔'
                );
                
                $this->info("✅ Reminder sent for: {$event->judul}");
            } catch (\Exception $e) {
                $this->error("❌ Failed to send reminder for: {$event->judul}");
                $this->error("   Error: " . $e->getMessage());
            }
        }
        
        $this->info("📬 Sent " . $upcomingEvents->count() . " reminder(s).");
        
        return SymfonyCommand::SUCCESS;
    }
}
