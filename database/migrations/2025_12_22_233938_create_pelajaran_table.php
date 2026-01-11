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
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelajaran');
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->string('hari')->nullable(); // Senin, Selasa, dst
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelajaran');
    }
};
