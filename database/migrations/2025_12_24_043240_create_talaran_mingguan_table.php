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
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->enum('semester', ['1', '2']);
            
            // Weekly Scores (0-10 or 0-100, let's allow decimals)
            $table->decimal('minggu_1', 5, 2)->nullable()->default(0);
            $table->decimal('minggu_2', 5, 2)->nullable()->default(0);
            $table->decimal('minggu_3', 5, 2)->nullable()->default(0);
            $table->decimal('minggu_4', 5, 2)->nullable()->default(0);
            
            $table->decimal('rata_rata', 5, 2)->nullable()->default(0);
            
            $table->timestamps();
            
            // Ensure unique record per student per mapel per term
            $table->unique(['santri_id', 'mapel_id', 'tahun_ajaran', 'semester'], 'talaran_unique_idx');
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
