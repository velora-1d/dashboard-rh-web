<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Asrama;
use App\Models\Kobong;
use Illuminate\Database\Seeder;

class SantriSeeder extends Seeder
{
    /**
     * Seed 108 santri (12 per kelas: 6 putra + 6 putri)
     */
    public function run(): void
    {
        $kelasList = Kelas::all();
        
        // Get asrama by gender
        $asramaPutra = Asrama::where('gender', 'putra')->get();
        $asramaPutri = Asrama::where('gender', 'putri')->get();
        
        // Nama-nama populer Indonesia
        $namaPutra = [
            'Ahmad', 'Muhammad', 'Abdullah', 'Ridwan', 'Fajar', 'Rizki',
            'Hafiz', 'Yusuf', 'Ibrahim', 'Ismail', 'Umar', 'Ali',
            'Hasan', 'Husein', 'Bilal', 'Zaid', 'Salman', 'Hamza',
            'Khalid', 'Malik', 'Naufal', 'Rafi', 'Dzaki', 'Faris',
            'Ghifari', 'Hakim', 'Ihsan', 'Jibril', 'Kholil', 'Lukman',
            'Mahdi', 'Najib', 'Qasim', 'Rafif', 'Syafiq', 'Taufiq',
            'Uwais', 'Wafi', 'Yahya', 'Zainal', 'Aiman', 'Bima',
            'Dimas', 'Eka', 'Farhan', 'Galih', 'Hanif', 'Irfan',
            'Joni', 'Kurnia', 'Lutfi', 'Mukhlis', 'Nur', 'Omar',
        ];
        
        $namaPutri = [
            'Aisyah', 'Fatimah', 'Khadijah', 'Maryam', 'Zahra', 'Siti',
            'Nur', 'Dewi', 'Putri', 'Rahma', 'Salsabila', 'Nadia',
            'Hafsa', 'Safiya', 'Layla', 'Amina', 'Halima', 'Ruqayya',
            'Zainab', 'Ummu', 'Hana', 'Rina', 'Dina', 'Lina',
            'Mira', 'Sara', 'Nisa', 'Fira', 'Gina', 'Hilda',
            'Indah', 'Jasmin', 'Kamila', 'Latifa', 'Mawar', 'Nabila',
            'Oktavia', 'Puspita', 'Qonita', 'Rania', 'Shafira', 'Tari',
            'Ulfah', 'Vina', 'Wulan', 'Xena', 'Yani', 'Zulfa',
            'Aliya', 'Bella', 'Citra', 'Diana', 'Eva', 'Fitri',
        ];
        
        $margaPutra = ['Hidayat', 'Ramadhan', 'Maulana', 'Firdaus', 'Hakim', 'Akbar'];
        $margaPutri = ['Azzahra', 'Ramadhani', 'Safitri', 'Handayani', 'Pratiwi', 'Lestari'];
        
        $counter = 1;
        
        foreach ($kelasList as $kelas) {
            // 6 Putra
            for ($i = 0; $i < 6; $i++) {
                $asrama = $asramaPutra->random();
                $kobong = Kobong::where('asrama_id', $asrama->id)->inRandomOrder()->first();
                
                $nama = $namaPutra[array_rand($namaPutra)] . ' ' . $margaPutra[array_rand($margaPutra)];
                
                Santri::create([
                    'nis' => '2024' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'nama_santri' => $nama,
                    'negara' => 'Indonesia',
                    'provinsi' => 'Jawa Barat',
                    'kota_kabupaten' => 'Tasikmalaya',
                    'kecamatan' => 'Sukarame',
                    'desa_kampung' => 'Sukarapih',
                    'rt_rw' => sprintf('%02d/%02d', rand(1, 10), rand(1, 10)),
                    'nama_ortu_wali' => 'Bapak ' . $namaPutra[array_rand($namaPutra)],
                    'no_hp_ortu_wali' => '08' . rand(11, 99) . rand(1000000, 9999999),
                    'asrama_id' => $asrama->id,
                    'kobong_id' => $kobong ? $kobong->id : null,
                    'kelas_id' => $kelas->id,
                    'gender' => 'putra',
                    'is_active' => true,
                ]);
                $counter++;
            }
            
            // 6 Putri
            for ($i = 0; $i < 6; $i++) {
                $asrama = $asramaPutri->random();
                $kobong = Kobong::where('asrama_id', $asrama->id)->inRandomOrder()->first();
                
                $nama = $namaPutri[array_rand($namaPutri)] . ' ' . $margaPutri[array_rand($margaPutri)];
                
                Santri::create([
                    'nis' => '2024' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'nama_santri' => $nama,
                    'negara' => 'Indonesia',
                    'provinsi' => 'Jawa Barat',
                    'kota_kabupaten' => 'Tasikmalaya',
                    'kecamatan' => 'Sukarame',
                    'desa_kampung' => 'Sukarapih',
                    'rt_rw' => sprintf('%02d/%02d', rand(1, 10), rand(1, 10)),
                    'nama_ortu_wali' => 'Ibu ' . $namaPutri[array_rand($namaPutri)],
                    'no_hp_ortu_wali' => '08' . rand(11, 99) . rand(1000000, 9999999),
                    'asrama_id' => $asrama->id,
                    'kobong_id' => $kobong ? $kobong->id : null,
                    'kelas_id' => $kelas->id,
                    'gender' => 'putri',
                    'is_active' => true,
                ]);
                $counter++;
            }
        }
    }
}
