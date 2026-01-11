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
        Schema::create('talaran_mingguan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tahun_ajaran'); // e.g., "2024/2025"
            $table->enum('semester', ['1', '2']);
            $table->integer('bulan'); // 1-12
            $table->integer('minggu_ke_bulan'); // 1-4 (week of the month)
            $table->integer('jumlah_talaran')->default(0); // Talaran count for this week
            $table->integer('total_akumulasi')->default(0); // Auto-calculated cumulative total
            $table->integer('jumlah_tamat')->default(0); // How many times completed the kitab
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Unique constraint: one record per student per week
            $table->unique(['santri_id', 'tahun_ajaran', 'semester', 'bulan', 'minggu_ke_bulan'], 'unique_talaran_week');
            
            // Indexes for faster queries
            $table->index('tahun_ajaran');
            $table->index('semester');
            $table->index('bulan');
            $table->index('kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talaran_mingguan');
    }
};
