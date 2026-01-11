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
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // Nomor Induk Santri
            $table->string('nama_santri');
            
            // Alamat lengkap
            $table->string('negara')->default('Indonesia');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('desa_kampung');
            $table->string('rt_rw');
            
            // Orang tua/wali
            $table->string('nama_ortu_wali');
            $table->string('no_hp_ortu_wali');
            
            // Penempatan
            $table->foreignId('asrama_id')->constrained('asrama')->onDelete('restrict');
            $table->foreignId('kobong_id')->constrained('kobong')->onDelete('restrict');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('restrict');
            
            $table->enum('gender', ['putra', 'putri']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
