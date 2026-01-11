<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use App\Models\NilaiSantri;
use App\Models\JadwalPelajaran;
use App\Models\Santri;
use App\Models\Kelas;

class PendidikanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Mata Pelajaran
        $mapel = [
            ['nama_mapel' => 'Tafsir', 'kode_mapel' => 'TFS01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Ahmad', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Hadits', 'kode_mapel' => 'HDT01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Mahmud', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Fiqih', 'kode_mapel' => 'FQH01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Yusuf', 'jam_pelajaran' => 4],
            ['nama_mapel' => 'Nahwu', 'kode_mapel' => 'NHW01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Hasan', 'jam_pelajaran' => 4],
            ['nama_mapel' => 'Shorof', 'kode_mapel' => 'SRF01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Ali', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Bahasa Arab', 'kode_mapel' => 'ARB01', 'kategori' => 'Agama', 'guru_pengampu' => 'Ust. Karim', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Matematika', 'kode_mapel' => 'MTK01', 'kategori' => 'Umum', 'guru_pengampu' => 'Ust. Ridwan', 'jam_pelajaran' => 4],
            ['nama_mapel' => 'Bahasa Indonesia', 'kode_mapel' => 'BIN01', 'kategori' => 'Umum', 'guru_pengampu' => 'Ust. Fauzi', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Bahasa Inggris', 'kode_mapel' => 'ENG01', 'kategori' => 'Umum', 'guru_pengampu' => 'Ust. Zaki', 'jam_pelajaran' => 3],
            ['nama_mapel' => 'Komputer', 'kode_mapel' => 'KOM01', 'kategori' => 'Ekstrakurikuler', 'guru_pengampu' => 'Ust. Fahmi', 'jam_pelajaran' => 2],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }

        // Seed Sample Nilai (5 santri pertama)
        $santriList = Santri::where('is_active', true)->limit(5)->get();
        $mapelList = MataPelajaran::all();
        $kelasList = Kelas::all();

        if ($santriList->count() > 0 && $mapelList->count() > 0 && $kelasList->count() > 0) {
            foreach ($santriList as $santri) {
                foreach ($mapelList->random(5) as $mapel) {
                    $nilai = NilaiSantri::create([
                        'santri_id' => $santri->id,
                        'mapel_id' => $mapel->id,
                        'kelas_id' => $kelasList->random()->id,
                        'semester' => '1',
                        'tahun_ajaran' => '2024/2025',
                        'nilai_uts' => rand(60, 100),
                        'nilai_uas' => rand(60, 100),
                        'nilai_tugas' => rand(70, 100),
                        'nilai_praktik' => rand(70, 100),
                    ]);
                    
                    $nilai->calculateNilaiAkhir();
                    $nilai->save();
                }
            }
        }

        // Seed Sample Jadwal
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamMulai = ['07:00', '08:30', '10:00', '13:00', '14:30'];
        
        if ($kelasList->count() > 0 && $mapelList->count() > 0) {
            foreach ($kelasList->take(3) as $kelas) {
                foreach ($hari as $index => $h) {
                    JadwalPelajaran::create([
                        'kelas_id' => $kelas->id,
                        'mapel_id' => $mapelList->random()->id,
                        'hari' => $h,
                        'jam_mulai' => $jamMulai[$index],
                        'jam_selesai' => date('H:i', strtotime($jamMulai[$index] . ' +90 minutes')),
                        'ruangan' => 'Ruang ' . chr(65 + $index),
                        'tahun_ajaran' => '2024/2025',
                        'semester' => '1',
                    ]);
                }
            }
        }
    }
}
