<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KobongSeeder extends Seeder
{
    public function run(): void
    {
        // Get all asrama IDs
        $asramaIds = DB::table('asrama')->pluck('id');
        
        // Create Kobong 1-20 for each asrama
        foreach ($asramaIds as $asramaId) {
            for ($i = 1; $i <= 20; $i++) {
                DB::table('kobong')->insert([
                    'asrama_id' => $asramaId,
                    'nomor_kobong' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
