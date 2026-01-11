<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbsensiSantri;
use App\Models\Santri;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $santri = Santri::with('kelas')->get();
        
        if ($santri->isEmpty()) {
            $this->command->warn('No santri found.');
            return;
        }
        
        $tahun = 2025;
        
        // Create absensi for each santri for 4 weeks
        foreach ($santri as $s) {
            for ($minggu = 1; $minggu <= 4; $minggu++) {
                $tanggalMulai = now()->startOfYear()->addWeeks($minggu - 1);
                $tanggalSelesai = $tanggalMulai->copy()->addDays(13); // 2 weeks
                
                AbsensiSantri::create([
                    'santri_id' => $s->id,
                    'kelas_id' => $s->kelas_id,
                    'tahun' => $tahun,
                    'minggu_ke' => $minggu,
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_selesai' => $tanggalSelesai,
                    'alfa_sorogan' => rand(0, 3),
                    'alfa_menghafal_malam' => rand(0, 3),
                    'alfa_menghafal_subuh' => rand(0, 3),
                    'alfa_tahajud' => rand(0, 3),
                    'keterangan' => 'Absensi minggu ke-' . $minggu,
                ]);
            }
        }
        
        $total = AbsensiSantri::count();
        $this->command->info($total . ' Absensi seeded successfully!');
    }
}
