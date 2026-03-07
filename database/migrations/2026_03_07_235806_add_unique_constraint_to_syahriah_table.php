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
        Schema::table('syahriah', function (Blueprint $table) {
            $table->unique(['santri_id', 'bulan', 'tahun'], 'syahriah_santri_bulan_tahun_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syahriah', function (Blueprint $table) {
            $table->dropUnique('syahriah_santri_bulan_tahun_unique');
        });
    }
};
