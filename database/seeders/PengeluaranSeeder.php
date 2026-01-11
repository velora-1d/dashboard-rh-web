<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['Operasional', 'Gaji', 'Pembelian', 'Perawatan', 'Lain-lain'];
        $jenisPengeluaran = [
            'Pembelian beras', 'Gaji guru', 'Listrik', 'Air', 'Internet',
            'ATK', 'Perawatan gedung', 'Pembelian buku', 'Transport', 'Konsumsi',
            'Pembelian gas', 'Kebersihan', 'Perawatan AC', 'Pembelian meja', 'Pembelian kursi',
            'Renovasi', 'Cat tembok', 'Pembelian komputer', 'Printer', 'Alat tulis'
        ];
        
        for ($i = 0; $i < 20; $i++) {
            Pengeluaran::create([
                'tanggal' => now()->subDays(rand(1, 90)),
                'kategori' => $kategori[array_rand($kategori)],
                'jenis_pengeluaran' => $jenisPengeluaran[$i],
                'nominal' => rand(50000, 3000000),
                'keterangan' => 'Pengeluaran untuk ' . $jenisPengeluaran[$i],
            ]);
        }
        
        $this->command->info('20 Pengeluaran seeded successfully!');
    }
}
