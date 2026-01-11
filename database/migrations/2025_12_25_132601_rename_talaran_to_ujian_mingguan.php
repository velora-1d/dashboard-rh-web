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
        // Rename table from talaran_mingguan to ujian_mingguan
        Schema::rename('talaran_mingguan', 'ujian_mingguan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: rename back to talaran_mingguan
        Schema::rename('ujian_mingguan', 'talaran_mingguan');
    }
};
