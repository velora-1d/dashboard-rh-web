<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    /**
     * Update kelas dengan wali kelas
     */
    public function run(): void
    {
        // Nama-nama ustadz/ustadzah untuk wali kelas
        $ustadz = [
            'Ust. Ahmad Fauzi',
            'Ust. Muhammad Ridwan',
            'Ust. Abdullah Hakim',
            'Ust. Hasan Basri',
            'Ust. Kholil Anwar',
            'Ust. Zainal Abidin',
            'Ust. Mahfudz Sholeh',
            'Ust. Sahal Mahfudz',
            'Ust. Anwar Musadad',
        ];
        
        $ustadzah = [
            'Ustdz. Aisyah Nur',
            'Ustdz. Fatimah Azzahra',
            'Ustdz. Khadijah Rahma',
            'Ustdz. Maryam Safitri',
            'Ustdz. Zahra Handayani',
            'Ustdz. Siti Aminah',
            'Ustdz. Nur Halimah',
            'Ustdz. Dewi Salsabila',
            'Ustdz. Putri Nabila',
        ];
        
        $kelasList = Kelas::all();
        
        $i = 0;
        foreach ($kelasList as $kelas) {
            if ($kelas->tipe_wali_kelas === 'dual') {
                // Dual wali kelas (putra & putri terpisah)
                $kelas->update([
                    'wali_kelas_putra' => $ustadz[$i % count($ustadz)],
                    'wali_kelas_putri' => $ustadzah[$i % count($ustadzah)],
                ]);
            } else {
                // Tunggal wali kelas
                $kelas->update([
                    'wali_kelas' => $ustadz[$i % count($ustadz)],
                ]);
            }
            $i++;
        }
    }
}
