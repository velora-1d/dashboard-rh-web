<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        
        if ($kelas->isEmpty() || $mapel->isEmpty()) {
            $this->command->warn('No kelas or mata pelajaran found.');
            return;
        }
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jamMulai = ['07:00', '08:30', '10:00', '13:00', '14:30'];
        $ruangan = ['Ruang A', 'Ruang B', 'Ruang C', 'Aula', 'Lab'];
        $tahunAjaran = '2024/2025';
        
        $count = 0;
        // Create 20 jadwal
        for ($i = 0; $i < 20; $i++) {
            $jamStart = $jamMulai[array_rand($jamMulai)];
            $jamEnd = date('H:i', strtotime($jamStart) + 5400); // +1.5 hours
            
            JadwalPelajaran::create([
                'kelas_id' => $kelas->random()->id,
                'mapel_id' => $mapel->random()->id,
                'hari' => $hari[array_rand($hari)],
                'jam_mulai' => $jamStart,
                'jam_selesai' => $jamEnd,
                'ruangan' => $ruangan[array_rand($ruangan)],
                'tahun_ajaran' => $tahunAjaran,
                'semester' => '1',
            ]);
            $count++;
        }
        
        $this->command->info($count . ' Jadwal Pelajaran seeded successfully!');
    }
}
