<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasMataPelajaranSeeder extends Seeder
{
    /**
     * Assign mata pelajaran ke setiap kelas
     */
    public function run(): void
    {
        $kelasList = Kelas::all();
        $mapelList = MataPelajaran::all();
        
        if ($mapelList->isEmpty()) {
            $this->command->error('Mata pelajaran belum ada! Jalankan MataPelajaranSeeder dulu.');
            return;
        }
        
        // Mapping mapel per tingkat
        $mapelPerTingkat = [
            'Ibtida' => [
                'Aqidatul Awam', 'Akhlaqul Banin/Banat', 'Safinatun Najah', 
                'Jurumiyah', 'Amtsilati Tasrifiyah', 'Tajwid', 'Qiroatul Quran',
                'Arbain Nawawi', 'Khulasoh Nurul Yaqin',
            ],
            'Tsanawi' => [
                'Tijan Durori', 'Taisirul Kholaq', 'Sullamut Taufiq', 'Fathul Qorib',
                'Imrithi', 'Qowaidul I\'lal', 'Tajwid', 'Tahfidz Al-Quran',
                'Bulughul Maram', 'Bidayatul Hidayah', 'Waraqat', 'Sullamul Munauruq',
            ],
            "Ma'had Aly" => [
                'Fathul Muin', 'Alfiyah Ibnu Malik', 'Tafsir Jalalain', 'Riyadhus Sholihin',
                'Ihya Ulumuddin', 'Minhajul Abidin', 'Jauharul Maknun', 'Lathoiful Isyarat',
                'Idhohul Mubham', 'Tarikh Tasyri\' Islami', 'Tahfidz Al-Quran',
            ],
            'Pengabdian' => [
                'Fathul Muin', 'Tafsir Jalalain', 'Ihya Ulumuddin', 'Tahfidz Al-Quran',
            ],
        ];
        
        foreach ($kelasList as $kelas) {
            $tingkat = $kelas->tingkat;
            $mapelNames = $mapelPerTingkat[$tingkat] ?? [];
            
            foreach ($mapelNames as $namaMapel) {
                $mapel = $mapelList->where('nama_mapel', $namaMapel)->first();
                
                if ($mapel) {
                    // Check if already exists
                    $exists = DB::table('kelas_mata_pelajaran')
                        ->where('kelas_id', $kelas->id)
                        ->where('mata_pelajaran_id', $mapel->id)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('kelas_mata_pelajaran')->insert([
                            'kelas_id' => $kelas->id,
                            'mata_pelajaran_id' => $mapel->id,
                            'is_kelas_umum' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
