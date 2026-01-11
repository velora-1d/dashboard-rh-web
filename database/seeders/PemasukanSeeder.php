<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pemasukan;

class PemasukanSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['Syahriah', 'Donasi', 'Infaq', 'Wakaf', 'Lain-lain'];
        $sumber = ['Santri', 'Donatur', 'Yayasan', 'Pemerintah', 'Umum'];
        
        for ($i = 1; $i <= 20; $i++) {
            Pemasukan::create([
                'tanggal' => now()->subDays(rand(1, 90)),
                'kategori' => $kategori[array_rand($kategori)],
                'sumber_pemasukan' => $sumber[array_rand($sumber)],
                'nominal' => rand(100000, 5000000),
                'keterangan' => 'Pemasukan ke-' . $i,
            ]);
        }
        
        $this->command->info('20 Pemasukan seeded successfully!');
    }
}
