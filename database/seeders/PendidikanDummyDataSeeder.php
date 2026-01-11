<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\NilaiSantri;
use App\Models\JadwalPelajaran;
use App\Models\AbsensiSantri;
use App\Models\Talaran;
use Carbon\Carbon;

class PendidikanDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = '2024/2025';
        $semester = 1;
        $currentYear = now()->year;
        
        // Get all classes and students
        $kelasList = Kelas::all();
        $mapelList = MataPelajaran::where('is_active', true)->get();
        
        if ($kelasList->isEmpty()) {
            $this->command->error('No classes found. Please seed Kelas data first.');
            return;
        }
        
        if ($mapelList->isEmpty()) {
            $this->command->error('No mata pelajaran found. Please seed MataPelajaran data first.');
            return;
        }
        
        $this->command->info('Starting to seed Pendidikan dummy data...');
        
        // For each class, create data
        foreach ($kelasList as $kelas) {
            $this->command->info("Processing Kelas: {$kelas->nama_kelas}");
            
            // Get 10 students from this class (or all if less than 10)
            $santriList = Santri::where('kelas_id', $kelas->id)
                ->where('is_active', true)
                ->limit(10)
                ->get();
            
            if ($santriList->isEmpty()) {
                $this->command->warn("No students found in {$kelas->nama_kelas}, skipping...");
                continue;
            }
            
            // 1. SEED NILAI SANTRI (10 records per class)
            $this->command->info("  - Seeding Nilai Santri...");
            foreach ($santriList as $santri) {
                // Create grades for 3-5 random subjects per student
                $randomMapels = $mapelList->random(min(5, $mapelList->count()));
                
                foreach ($randomMapels as $mapel) {
                    // Generate random grades
                    $nilaiUts = rand(60, 100);
                    $nilaiUas = rand(60, 100);
                    $nilaiTugas = rand(70, 100);
                    $nilaiPraktik = rand(65, 100);
                    
                    $nilai = NilaiSantri::updateOrCreate(
                        [
                            'santri_id' => $santri->id,
                            'mapel_id' => $mapel->id,
                            'semester' => $semester,
                            'tahun_ajaran' => $tahunAjaran,
                        ],
                        [
                            'kelas_id' => $kelas->id,
                            'nilai_uts' => $nilaiUts,
                            'nilai_uas' => $nilaiUas,
                            'nilai_tugas' => $nilaiTugas,
                            'nilai_praktik' => $nilaiPraktik,
                            'catatan' => 'Data dummy untuk testing dashboard',
                        ]
                    );
                    
                    // Calculate final grade
                    $nilai->calculateNilaiAkhir();
                    $nilai->save();
                }
            }
            
            // 2. SEED JADWAL PELAJARAN (schedules for this class)
            $this->command->info("  - Seeding Jadwal Pelajaran...");
            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $jamMulai = ['07:00', '08:30', '10:00', '13:00', '14:30'];
            
            // Create 5-8 schedules per class
            $scheduleCount = rand(5, 8);
            for ($i = 0; $i < $scheduleCount; $i++) {
                $randomMapel = $mapelList->random();
                $randomHari = $hari[array_rand($hari)];
                $randomJam = $jamMulai[array_rand($jamMulai)];
                $jamSelesai = date('H:i', strtotime($randomJam . ' +90 minutes'));
                
                JadwalPelajaran::create([
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $randomMapel->id,
                    'hari' => $randomHari,
                    'jam_mulai' => $randomJam,
                    'jam_selesai' => $jamSelesai,
                    'ruangan' => 'Ruang ' . chr(65 + rand(0, 5)), // A-F
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $semester,
                ]);
            }
            
            // 3. SEED ABSENSI SANTRI (attendance records)
            $this->command->info("  - Seeding Absensi Santri...");
            foreach ($santriList as $santri) {
                // Create 2-4 attendance records per student (different weeks)
                $recordCount = rand(2, 4);
                for ($week = 1; $week <= $recordCount; $week++) {
                    $mingguKe = $week * 2; // Week 2, 4, 6, 8
                    $period = AbsensiSantri::getTwoWeekPeriod($mingguKe, $currentYear);
                    
                    AbsensiSantri::create([
                        'santri_id' => $santri->id,
                        'kelas_id' => $kelas->id,
                        'tahun' => $currentYear,
                        'minggu_ke' => $mingguKe,
                        'tanggal_mulai' => $period['start'],
                        'tanggal_selesai' => $period['end'],
                        'alfa_sorogan' => rand(0, 3),
                        'alfa_menghafal_malam' => rand(0, 2),
                        'alfa_menghafal_subuh' => rand(0, 2),
                        'alfa_tahajud' => rand(0, 1),
                        'keterangan' => rand(0, 10) > 7 ? 'Sakit' : null,
                    ]);
                }
            }
            
            // 4. SEED TALARAN DATA
            $this->command->info("  - Seeding Talaran Data...");
            $bulanList = ['Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir', 'Jumadil Awal', 'Jumadil Akhir'];
            $currentYear = now()->year;
            
            foreach ($santriList as $santri) {
                // Create talaran records for 2-3 months
                foreach (array_slice($bulanList, 0, rand(2, 3)) as $bulan) {
                    // Generate random talaran counts for each week
                    $minggu1 = rand(5, 15);
                    $minggu2 = rand(5, 15);
                    $minggu3 = rand(5, 15);
                    $minggu4 = rand(5, 15);
                    $tamat = rand(0, 3);
                    $alfa = rand(0, 4);
                    
                    Talaran::create([
                        'santri_id' => $santri->id,
                        'bulan' => $bulan,
                        'tahun' => $currentYear,
                        'minggu_1' => $minggu1,
                        'minggu_2' => $minggu2,
                        'minggu_3' => $minggu3,
                        'minggu_4' => $minggu4,
                        'jumlah' => $minggu1 + $minggu2 + $minggu3 + $minggu4,
                        'tamat' => $tamat,
                        'alfa' => $alfa,
                        'jumlah_1_2' => $minggu1 + $minggu2,
                        'jumlah_3_4' => $minggu3 + $minggu4,
                    ]);
                }
            }
        }
        
        $this->command->info('✅ Pendidikan dummy data seeded successfully!');
        $this->command->info('Summary:');
        $this->command->info('  - Nilai Santri: ' . NilaiSantri::count() . ' records');
        $this->command->info('  - Jadwal Pelajaran: ' . JadwalPelajaran::count() . ' records');
        $this->command->info('  - Absensi Santri: ' . AbsensiSantri::count() . ' records');
        $this->command->info('  - Talaran: ' . Talaran::count() . ' records');
    }
}
