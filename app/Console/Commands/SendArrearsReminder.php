<?php

namespace App\Console\Commands;

use App\Models\Santri;
use App\Models\Syahriah;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendArrearsReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:arrears {--force : Force send even if already sent today}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automatic reminder for outstanding arrears via Telegram';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Mengecek tunggakan santri...');

        // Get all active santri with arrears
        $currentYear = date('Y');
        $currentMonth = date('n');

        // Get santri with unpaid syahriah
        $santriWithArrears = Santri::where('is_active', true)
            ->with(['kelas', 'asrama'])
            ->get()
            ->map(function ($santri) use ($currentYear, $currentMonth) {
                // Count unpaid months
                $unpaidCount = Syahriah::where('santri_id', $santri->id)
                    ->where('is_lunas', false)
                    ->count();

                if ($unpaidCount === 0) {
                    return null;
                }

                // Calculate total arrears
                $totalArrears = Syahriah::where('santri_id', $santri->id)
                    ->where('is_lunas', false)
                    ->sum('nominal');

                return [
                    'nama' => $santri->nama,
                    'kelas' => $santri->kelas?->nama_kelas ?? '-',
                    'asrama' => $santri->asrama?->nama_asrama ?? '-',
                    'bulan_tunggakan' => $unpaidCount,
                    'tunggakan' => $totalArrears,
                ];
            })
            ->filter()
            ->sortByDesc('tunggakan')
            ->values()
            ->toArray();

        if (empty($santriWithArrears)) {
            $this->info('✅ Tidak ada tunggakan! Semua santri lunas.');
            return 0;
        }

        $this->info('📋 Ditemukan ' . count($santriWithArrears) . ' santri dengan tunggakan.');

        // Send via Telegram
        try {
            $telegram = new TelegramService();
            $result = $telegram->notifyArrearsWarning($santriWithArrears);

            if ($result) {
                $this->info('✅ Notifikasi berhasil dikirim ke Telegram!');
            } else {
                $this->error('❌ Gagal mengirim notifikasi ke Telegram.');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }

        // Show summary
        $this->newLine();
        $this->table(
            ['No', 'Nama Santri', 'Kelas', 'Bulan', 'Tunggakan'],
            collect($santriWithArrears)->take(10)->map(function ($item, $idx) {
                return [
                    $idx + 1,
                    $item['nama'],
                    $item['kelas'],
                    $item['bulan_tunggakan'] . ' bln',
                    'Rp ' . number_format($item['tunggakan'], 0, ',', '.'),
                ];
            })->toArray()
        );

        $totalAmount = array_sum(array_column($santriWithArrears, 'tunggakan'));
        $this->info('💰 Total Tunggakan: Rp ' . number_format($totalAmount, 0, ',', '.'));

        return 0;
    }
}
