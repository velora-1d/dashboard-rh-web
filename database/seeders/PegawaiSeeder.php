<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $jabatan = ['Guru', 'Staf Administrasi', 'Pengurus Asrama', 'Pengurus Dapur', 'Keamanan'];
        $departemen = ['Pendidikan', 'Administrasi', 'Asrama', 'Umum', 'Keamanan'];
        
        $namaPegawai = [
            'Ustadz Ahmad Fauzi', 'Ustadz Muhammad Hadi', 'Ustadzah Fatimah', 'Ustadzah Aisyah',
            'Pak Budi Santoso', 'Ibu Siti Aminah', 'Pak Joko Widodo', 'Ibu Nur Hidayah',
            'Pak Agus Salim', 'Ibu Dewi Sartika', 'Pak Hasan Basri', 'Ibu Khadijah',
            'Pak Yusuf Ibrahim', 'Ibu Maryam', 'Pak Ali Akbar', 'Ibu Zainab',
            'Pak Umar Faruq', 'Ibu Hafsah', 'Pak Idris Amin', 'Ibu Ruqayyah'
        ];
        
        foreach ($namaPegawai as $index => $nama) {
            Pegawai::create([
                'nama_pegawai' => $nama,
                'jabatan' => $jabatan[array_rand($jabatan)],
                'departemen' => $departemen[array_rand($departemen)],
                'no_hp' => '0813' . rand(10000000, 99999999),
                'alamat' => 'Pasuruan, Jawa Timur',
                'is_active' => true,
            ]);
        }
        
        $this->command->info('20 Pegawai seeded successfully!');
    }
}
