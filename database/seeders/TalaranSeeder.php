<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UjianMingguan;
use App\Models\Santri;

class TalaranSeeder extends Seeder
{
    public function run(): void
    {
        $santri = Santri::all();
        
        if ($santri->isEmpty()) {
            $this->command->warn('No santri found.');
            return;
        }
        
        $tahunAjaran = '2024/2025';
        $semester = 1;
        
        // Create talaran for each santri for 4 weeks in 2 months
        $count = 0;
        foreach ($santri as $s) {
            $totalAkumulasi = 0;
            
            // Month 1
            for ($minggu = 1; $minggu <= 4; $minggu++) {
                $jumlah = rand(5, 20);
                $totalAkumulasi += $jumlah;
                
                UjianMingguan::create([
                    'santri_id' => $s->id,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                    'bulan' => 1,
                    'minggu' => $minggu,
                    'jumlah_talaran' => $jumlah,
                    'total_akumulasi' => $totalAkumulasi,
                    'tamat_counter' => 0,
                ]);
                $count++;
            }
            
            // Month 2
            for ($minggu = 1; $minggu <= 4; $minggu++) {
                $jumlah = rand(5, 20);
                $totalAkumulasi += $jumlah;
                
                UjianMingguan::create([
                    'santri_id' => $s->id,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                    'bulan' => 2,
                    'minggu' => $minggu,
                    'jumlah_talaran' => $jumlah,
                    'total_akumulasi' => $totalAkumulasi,
                    'tamat_counter' => $totalAkumulasi >= 100 ? 1 : 0,
                ]);
                $count++;
            }
        }
        
        $this->command->info($count . ' Talaran Mingguan seeded successfully!');
    }
}
