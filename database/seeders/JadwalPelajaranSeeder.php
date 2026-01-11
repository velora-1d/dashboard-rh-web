<?php

namespace Database\Seeders;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Seed jadwal pelajaran: 5 jam per hari x 6 hari = 30 jadwal per kelas
     */
    public function run(): void
    {
        $kelasList = Kelas::all();
        $mapelList = MataPelajaran::where('is_active', true)->get();
        
        if ($mapelList->isEmpty()) {
            $this->command->error('Mata pelajaran belum ada! Jalankan MataPelajaranSeeder dulu.');
            return;
        }
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Jam pelajaran pesantren (5 sesi per hari)
        $jamPelajaran = [
            ['mulai' => '08:00', 'selesai' => '08:45'],
            ['mulai' => '09:00', 'selesai' => '09:45'],
            ['mulai' => '10:00', 'selesai' => '10:45'],
            ['mulai' => '13:00', 'selesai' => '13:45'],
            ['mulai' => '14:00', 'selesai' => '14:45'],
        ];
        
        $tahunAjaran = '2024/2025';
        $semester = '1';
        
        foreach ($kelasList as $kelas) {
            $mapelIndex = 0;
            
            foreach ($hari as $namaHari) {
                foreach ($jamPelajaran as $index => $jam) {
                    // Rotate through mata pelajaran
                    $mapel = $mapelList[$mapelIndex % $mapelList->count()];
                    
                    JadwalPelajaran::create([
                        'kelas_id' => $kelas->id,
                        'mapel_id' => $mapel->id,
                        'hari' => $namaHari,
                        'jam_mulai' => $jam['mulai'],
                        'jam_selesai' => $jam['selesai'],
                        'ruangan' => 'Ruang ' . $kelas->nama_kelas,
                        'tahun_ajaran' => $tahunAjaran,
                        'semester' => $semester,
                    ]);
                    
                    $mapelIndex++;
                }
            }
        }
    }
}
