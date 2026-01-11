<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Syahriah;
use App\Models\Santri;

class SyahriahSeeder extends Seeder
{
    public function run(): void
    {
        $santri = Santri::limit(20)->get();
        
        if ($santri->isEmpty()) {
            $this->command->warn('No santri found. Please run SantriSeeder first.');
            return;
        }
        
        $tahun = 2024;
        
        foreach ($santri as $s) {
            // Create syahriah for random month (1-12)
            $bulan = rand(1, 12);
            $isLunas = rand(0, 1);
            
            Syahriah::create([
                'santri_id' => $s->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'nominal' => 500000,
                'is_lunas' => $isLunas,
                'tanggal_bayar' => $isLunas ? now()->subDays(rand(1, 30)) : null,
                'keterangan' => 'Syahriah bulan ' . $bulan . ' tahun ' . $tahun,
            ]);
        }
        
        $this->command->info('20 Syahriah seeded successfully!');
    }
}
