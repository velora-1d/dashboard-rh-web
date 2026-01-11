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
        Schema::create('mutasi_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->enum('jenis_mutasi', ['masuk', 'keluar', 'pindah_kelas', 'pindah_asrama']);
            $table->date('tanggal_mutasi');
            $table->text('keterangan')->nullable();
            $table->string('dari')->nullable(); // Untuk pindah kelas/asrama
            $table->string('ke')->nullable(); // Untuk pindah kelas/asrama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_santri');
    }
};
