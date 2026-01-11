<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KelasSeeder::class,
            AsramaSeeder::class,
            KobongSeeder::class,
            UserSeeder::class,
            WaliKelasSeeder::class,
            SantriSeeder::class,
            MataPelajaranSeeder::class,
            KelasMataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
        ]);
        
        // Seed Report Settings
        if (\App\Models\ReportSettings::count() === 0) {
            \App\Models\ReportSettings::create([
                'nama_yayasan' => 'YAYASAN PONDOK PESANTREN',
                'nama_pondok' => 'RIYADLUL HUDA',
                'alamat' => 'Jl. Taman Makam Pahlawan KHZ. Mustofa Sukaguru Sukarapih Sukarame',
                'telepon' => '(0265) 545812, 546310',
                'kota_terbit' => 'Tasikmalaya',
                'pimpinan_nama' => 'KH. Undang Ubaidillah',
                'pimpinan_jabatan' => 'Pimpinan Umum',
                'logo_pondok_path' => 'images/logo_pondok.png',
                'logo_pendidikan_path' => 'images/logo_pendidikan.png',
            ]);
        }
    }
}
