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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alfa']);
            $table->integer('tahun');
            $table->integer('semester'); // 1 atau 2
            $table->integer('bulan'); // 1-12
            $table->integer('minggu'); // 1-5
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['santri_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
