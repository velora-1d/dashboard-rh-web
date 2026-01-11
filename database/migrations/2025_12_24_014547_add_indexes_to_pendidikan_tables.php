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
        // Schema::table('nilai_santri', function (Blueprint $table) {
        //     $table->index('santri_id');
        //     $table->index('mata_pelajaran_id');
        //     $table->index(['kelas_id', 'tahun_ajaran']);
        // });

        // Schema::table('jadwal_pelajaran', function (Blueprint $table) {
        //     $table->index('kelas_id');
        //     $table->index('mapel_id');
        //     $table->index(['tahun_ajaran', 'semester']);
        //     $table->index('hari');
        // });

        // Schema::table('absensi_santri', function (Blueprint $table) {
        //     $table->index('santri_id');
        //     $table->index(['tahun', 'minggu_ke']);
        // });
        
        // Schema::table('santri', function (Blueprint $table) {
        //     $table->index(['kelas_id', 'is_active']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_santri', function (Blueprint $table) {
            $table->dropIndex(['tahun_ajaran', 'semester']);
            $table->dropIndex(['santri_id']);
            $table->dropIndex(['mata_pelajaran_id']);
            $table->dropIndex(['kelas_id', 'tahun_ajaran']);
        });

        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropIndex(['kelas_id']);
            $table->dropIndex(['mapel_id']);
            $table->dropIndex(['tahun_ajaran', 'semester']);
            $table->dropIndex(['hari']);
        });

        Schema::table('absensi_santri', function (Blueprint $table) {
            $table->dropIndex(['santri_id']);
            $table->dropIndex(['tahun', 'minggu_ke']);
            $table->dropIndex(['kelas_id']);
        });
        
        Schema::table('santri', function (Blueprint $table) {
            $table->dropIndex(['kelas_id', 'is_active']);
        });
    }
};
