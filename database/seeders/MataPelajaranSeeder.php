<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Seed mata pelajaran pesantren
     */
    public function run(): void
    {
        $mataPelajaran = [
            // Pelajaran Aqidah & Akhlak
            ['nama_mapel' => 'Aqidatul Awam', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Tijan Durori', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Akhlaqul Banin/Banat', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Taisirul Kholaq', 'kategori' => 'Diniyah', 'kkm' => 70],
            
            // Pelajaran Fiqih
            ['nama_mapel' => 'Safinatun Najah', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Sullamut Taufiq', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Fathul Qorib', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Taqrib', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Fathul Muin', 'kategori' => 'Diniyah', 'kkm' => 75],
            
            // Pelajaran Nahwu & Shorof
            ['nama_mapel' => 'Jurumiyah', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Imrithi', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Alfiyah Ibnu Malik', 'kategori' => 'Diniyah', 'kkm' => 75],
            ['nama_mapel' => 'Amtsilati Tasrifiyah', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Qowaidul I\'lal', 'kategori' => 'Diniyah', 'kkm' => 70],
            
            // Pelajaran Tafsir & Hadits
            ['nama_mapel' => 'Tafsir Jalalain', 'kategori' => 'Diniyah', 'kkm' => 75],
            ['nama_mapel' => 'Arbain Nawawi', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Bulughul Maram', 'kategori' => 'Diniyah', 'kkm' => 75],
            ['nama_mapel' => 'Riyadhus Sholihin', 'kategori' => 'Diniyah', 'kkm' => 70],
            
            // Pelajaran Tajwid & Al-Quran
            ['nama_mapel' => 'Tajwid', 'kategori' => 'Diniyah', 'kkm' => 75, 'is_talaran' => true],
            ['nama_mapel' => 'Tahfidz Al-Quran', 'kategori' => 'Diniyah', 'kkm' => 80, 'is_talaran' => true],
            ['nama_mapel' => 'Qiroatul Quran', 'kategori' => 'Diniyah', 'kkm' => 75, 'is_talaran' => true],
            
            // Pelajaran Tasawuf
            ['nama_mapel' => 'Bidayatul Hidayah', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Minhajul Abidin', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Ihya Ulumuddin', 'kategori' => 'Diniyah', 'kkm' => 75],
            
            // Pelajaran Balaghah
            ['nama_mapel' => 'Jauharul Maknun', 'kategori' => 'Diniyah', 'kkm' => 75],
            
            // Pelajaran Ushul Fiqh
            ['nama_mapel' => 'Waraqat', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Lathoiful Isyarat', 'kategori' => 'Diniyah', 'kkm' => 75],
            
            // Pelajaran Mantiq
            ['nama_mapel' => 'Sullamul Munauruq', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Idhohul Mubham', 'kategori' => 'Diniyah', 'kkm' => 75],
            
            // Pelajaran Sejarah Islam
            ['nama_mapel' => 'Khulasoh Nurul Yaqin', 'kategori' => 'Diniyah', 'kkm' => 70],
            ['nama_mapel' => 'Tarikh Tasyri\' Islami', 'kategori' => 'Diniyah', 'kkm' => 70],
        ];
        
        $counter = 1;
        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create(array_merge($mapel, [
                'kode_mapel' => 'MP' . str_pad($counter, 3, '0', STR_PAD_LEFT),
                'guru_pengampu' => $this->randomGuru(),
                'guru_badal' => $this->randomGuru(),
                'is_active' => true,
            ]));
            $counter++;
        }
    }
    
    private function randomGuru(): string
    {
        $gelar = ['Ust.', 'Ustdz.', 'KH.', 'Gus', 'Ning'];
        $nama = ['Ahmad', 'Muhammad', 'Abdullah', 'Hasan', 'Husein', 'Zainal', 'Kholil', 'Mahfudz', 'Sahal', 'Anwar'];
        $marga = ['Hidayat', 'Maulana', 'Firdaus', 'Hakim', 'Akbar', 'Ridwan'];
        
        return $gelar[array_rand($gelar)] . ' ' . $nama[array_rand($nama)] . ' ' . $marga[array_rand($marga)];
    }
}
