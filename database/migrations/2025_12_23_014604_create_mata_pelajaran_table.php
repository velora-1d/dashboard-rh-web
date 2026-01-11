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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel');
            $table->string('kode_mapel')->unique();
            $table->enum('kategori', ['Agama', 'Umum', 'Ekstrakurikuler'])->default('Umum');
            $table->string('guru_pengampu')->nullable();
            $table->enum('waktu_pelajaran', ['Subuh', 'Pagi', 'Siang', 'Sore', 'Malam'])->default('Pagi');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
