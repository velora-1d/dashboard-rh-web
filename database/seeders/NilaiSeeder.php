<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NilaiSantri;
use App\Models\Santri;
use App\Models\MataPelajaran;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $santri = Santri::with('kelas')->get();
        $mapel = MataPelajaran::all();
        
        if ($santri->isEmpty() || $mapel->isEmpty()) {
            $this->command->warn('No santri or mata pelajaran found.');
            return;
        }
        
        $tahunAjaran = '2024/2025';
        $semester = '1';
        
        // Create nilai for each santri for random mapel
        foreach ($santri as $s) {
            // Each santri gets 3-5 random mapel
            $randomMapel = $mapel->random(min(rand(3, 5), $mapel->count()));
            
            foreach ($randomMapel as $m) {
                NilaiSantri::create([
                    'santri_id' => $s->id,
                    'mapel_id' => $m->id,
                    'kelas_id' => $s->kelas_id,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                    'nilai_uts' => rand(60, 100),
                    'nilai_uas' => rand(60, 100),
                    'nilai_tugas' => rand(70, 100),
                    'nilai_praktik' => rand(70, 100),
                    'catatan' => 'Nilai semester ' . $semester,
                ]);
            }
        }
        
        $total = NilaiSantri::count();
        $this->command->info($total . ' Nilai seeded successfully!');
    }
}
