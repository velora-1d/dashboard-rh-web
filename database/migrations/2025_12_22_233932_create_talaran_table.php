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
        Schema::create('talaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->integer('tahun');
            $table->integer('semester'); // 1 atau 2
            $table->integer('bulan'); // 1-12
            $table->integer('minggu'); // 1-5
            $table->integer('jumlah_setoran')->default(0); // Jumlah hafalan/setoran mingguan
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['santri_id', 'tahun', 'semester', 'bulan', 'minggu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talaran');
    }
};
