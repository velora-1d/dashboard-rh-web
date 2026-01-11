<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\NilaiSantri;
use App\Models\UjianMingguan;
use App\Models\Syahriah;
use Carbon\Carbon;

class MigrasiTahunAjaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tahun-ajaran:migrasi 
                            {dari : Tahun ajaran asal (contoh: 2024-2025)}
                            {ke : Tahun ajaran tujuan (contoh: 2025-2026)}
                            {--kenaikan : Proses kenaikan kelas otomatis}
                            {--dry-run : Simulasi tanpa menyimpan perubahan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi data santri ke tahun ajaran baru dengan kenaikan kelas otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dari = $this->argument('dari');
        $ke = $this->argument('ke');
        $kenaikan = $this->option('kenaikan');
        $dryRun = $this->option('dry-run');
        
        $this->info("📚 Migrasi Tahun Ajaran: {$dari} → {$ke}");
        $this->info($dryRun ? "🔍 Mode: DRY RUN (simulasi)" : "⚡ Mode: LIVE (akan menyimpan perubahan)");
        $this->newLine();
        
        // Get all active students
        $santris = Santri::where('status', 'aktif')->with('kelas')->get();
        $this->info("📊 Total santri aktif: {$santris->count()}");
        
        if ($santris->isEmpty()) {
            $this->warn("⚠️ Tidak ada santri aktif ditemukan!");
            return 1; // Command::FAILURE
        }
        
        // Get kelas order for promotion
        $kelasOrder = [
            '1 Ibtida' => '2 Ibtida',
            '2 Ibtida' => '3 Ibtida',
            '3 Ibtida' => '1 Tsanawi',
            '1 Tsanawi' => '2 Tsanawi',
            '2 Tsanawi' => '3 Tsanawi',
            '3 Tsanawi' => '1-2 Ma\'had Aly',
            '1-2 Ma\'had Aly' => '3-4 Ma\'had Aly',
            '3-4 Ma\'had Aly' => 'Pengabdian',
            'Pengabdian' => 'LULUS',
        ];
        
        $stats = [
            'naik_kelas' => 0,
            'tetap' => 0,
            'lulus' => 0,
            'syahriah_created' => 0,
        ];
        
        $this->withProgressBar($santris, function ($santri) use ($kenaikan, $dryRun, $kelasOrder, $ke, &$stats) {
            if ($kenaikan && $santri->kelas) {
                $currentKelas = $santri->kelas->nama_kelas;
                $nextKelasName = $kelasOrder[$currentKelas] ?? null;
                
                if ($nextKelasName === 'LULUS') {
                    // Student graduates
                    if (!$dryRun) {
                        $santri->update(['status' => 'lulus']);
                    }
                    $stats['lulus']++;
                } elseif ($nextKelasName) {
                    // Promote to next class
                    $nextKelas = Kelas::where('nama_kelas', $nextKelasName)->first();
                    if ($nextKelas && !$dryRun) {
                        $santri->update(['kelas_id' => $nextKelas->id]);
                    }
                    $stats['naik_kelas']++;
                } else {
                    $stats['tetap']++;
                }
            } else {
                $stats['tetap']++;
            }
            
            // Create syahriah records for new year (July - June)
            if (!$dryRun && $santri->status === 'aktif') {
                $tahun = explode('-', $ke)[0]; // Get first year
                for ($bulan = 7; $bulan <= 12; $bulan++) {
                    Syahriah::firstOrCreate([
                        'santri_id' => $santri->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ], [
                        'nominal' => 300000, // Default nominal
                        'is_lunas' => false,
                    ]);
                    $stats['syahriah_created']++;
                }
                
                $tahunNext = explode('-', $ke)[1]; // Get second year
                for ($bulan = 1; $bulan <= 6; $bulan++) {
                    Syahriah::firstOrCreate([
                        'santri_id' => $santri->id,
                        'bulan' => $bulan,
                        'tahun' => $tahunNext,
                    ], [
                        'nominal' => 300000, // Default nominal
                        'is_lunas' => false,
                    ]);
                    $stats['syahriah_created']++;
                }
            }
        });
        
        $this->newLine(2);
        $this->info("📈 HASIL MIGRASI:");
        $this->table(
            ['Keterangan', 'Jumlah'],
            [
                ['Naik Kelas', $stats['naik_kelas']],
                ['Tetap', $stats['tetap']],
                ['Lulus', $stats['lulus']],
                ['Syahriah Baru', $stats['syahriah_created']],
            ]
        );
        
        if ($dryRun) {
            $this->warn("⚠️ Ini adalah simulasi. Jalankan tanpa --dry-run untuk menyimpan perubahan.");
        } else {
            $this->info("✅ Migrasi tahun ajaran selesai!");
        }
        
        return 0; // Command::SUCCESS
    }
}
