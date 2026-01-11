<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('talaran_santri', function (Blueprint $table) {
            // Composite index for reporting (filtering by month/year is very common)
            // Checking if index exists is complex in migration dsl, but simply adding it 
            // with a specific name allows us to drop it safely in down()
            // Using a try-catch equivalent by checking schema if possible, or just standard add
            
            // Note: create_talaran_santri_table already added individual indexes and [santri_id, bulan, tahun].
            // We add [bulan, tahun] specifically for the "Cetak Per Periode" query which groups by month/year 
            // across ALL santri (not just one santri).
            
            $table->index(['bulan', 'tahun'], 'idx_talaran_bulan_tahun');
            
            // Ensure santri_id is indexed for the FK join (it usually is, but explicit is good for performance)
            // Since we have a composite starting with santri_id, that covers it. 
            // But we can add a specific foreign key index if desired. 
            // Existing migration has: $table->index(['santri_id', 'bulan', 'tahun']);
            // This covers searches for 'santri_id'.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talaran_santri', function (Blueprint $table) {
            $table->dropIndex('idx_talaran_bulan_tahun');
        });
    }
};
