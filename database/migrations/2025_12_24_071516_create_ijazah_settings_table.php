<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ijazah_settings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_ijazah')->nullable(); // Global date for all ijazah
            $table->integer('last_nomor_ibtida')->default(0); // Counter for Ijazah Ibtida
            $table->integer('last_nomor_tsanawi')->default(0); // Counter for Ijazah Tsanawi
            $table->string('tahun_ajaran')->nullable(); // e.g., "2024/2025"
            $table->timestamps();
        });

        // Insert default record
        DB::table('ijazah_settings')->insert([
            'tanggal_ijazah' => now()->format('Y-m-d'),
            'last_nomor_ibtida' => 0,
            'last_nomor_tsanawi' => 0,
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ijazah_settings');
    }
};
