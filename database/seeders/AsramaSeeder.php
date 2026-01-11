<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asrama;

class AsramaSeeder extends Seeder
{
    public function run(): void
    {
        $asrama = [
            ['nama_asrama' => 'Zaid bin Tsabit', 'gender' => 'putra'],
            ['nama_asrama' => 'Thoriq bin Ziyad', 'gender' => 'putra'],
            ['nama_asrama' => 'Lubna', 'gender' => 'putri'],
            ['nama_asrama' => 'Bilqis', 'gender' => 'putri'],
            ['nama_asrama' => 'Yuhanada', 'gender' => 'putri'],
        ];

        foreach ($asrama as $a) {
            Asrama::firstOrCreate(
                ['nama_asrama' => $a['nama_asrama'], 'gender' => $a['gender']],
                $a
            );
        }
    }
}
