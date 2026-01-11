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
        Schema::create('nilai_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_ajaran'); // Format: 2024/2025
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_praktik', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable(); // Calculated
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Unique constraint: one grade per student per subject per semester
            $table->unique(['santri_id', 'mapel_id', 'semester', 'tahun_ajaran'], 'unique_nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_santri');
    }
};
