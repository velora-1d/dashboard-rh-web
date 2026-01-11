<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            // Ibtida (dual wali kelas)
            ['nama_kelas' => '1 Ibtida', 'tingkat' => 'Ibtida', 'level' => 1, 'tipe_wali_kelas' => 'dual'],
            ['nama_kelas' => '2 Ibtida', 'tingkat' => 'Ibtida', 'level' => 2, 'tipe_wali_kelas' => 'dual'],
            ['nama_kelas' => '3 Ibtida', 'tingkat' => 'Ibtida', 'level' => 3, 'tipe_wali_kelas' => 'dual'],
            
            // Tsanawi (1 = dual, 2&3 = tunggal)
            ['nama_kelas' => '1 Tsanawi', 'tingkat' => 'Tsanawi', 'level' => 1, 'tipe_wali_kelas' => 'dual'],
            ['nama_kelas' => '2 Tsanawi', 'tingkat' => 'Tsanawi', 'level' => 2, 'tipe_wali_kelas' => 'tunggal'],
            ['nama_kelas' => '3 Tsanawi', 'tingkat' => 'Tsanawi', 'level' => 3, 'tipe_wali_kelas' => 'tunggal'],
            
            // Ma'had Aly - MERGED (tunggal wali kelas)
            ['nama_kelas' => "1-2 Ma'had Aly", 'tingkat' => "Ma'had Aly", 'level' => 12, 'tipe_wali_kelas' => 'tunggal'],
            ['nama_kelas' => "3-4 Ma'had Aly", 'tingkat' => "Ma'had Aly", 'level' => 34, 'tipe_wali_kelas' => 'tunggal'],
            
            // Pengabdian (no wali kelas needed, but using tunggal as default)
            ['nama_kelas' => 'Pengabdian', 'tingkat' => 'Pengabdian', 'level' => null, 'tipe_wali_kelas' => 'tunggal'],
        ];

        foreach ($kelas as $k) {
            DB::table('kelas')->insert(array_merge($k, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
