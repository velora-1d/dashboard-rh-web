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
        Schema::create('absensi_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->integer('tahun'); // Year (e.g., 2025)
            $table->integer('minggu_ke'); // Week number (1-52)
            $table->date('tanggal_mulai'); // Start date of 2-week period
            $table->date('tanggal_selesai'); // End date of 2-week period
            
            // Alfa counts for each activity
            $table->integer('alfa_sorogan')->default(0);
            $table->integer('alfa_menghafal_malam')->default(0);
            $table->integer('alfa_menghafal_subuh')->default(0);
            $table->integer('alfa_tahajud')->default(0);
            
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Unique constraint: one record per student per 2-week period
            $table->unique(['santri_id', 'tahun', 'minggu_ke'], 'unique_absensi_period');
            
            // Indexes for faster queries
            $table->index('tahun');
            $table->index('minggu_ke');
            $table->index('kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_santri');
    }
};
