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
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_yayasan')->default('YAYASAN PONDOK PESANTREN');
            $table->string('nama_pondok')->default('RIYADLUL HUDA');
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('kota_terbit')->default('Tasikmalaya');
            $table->string('pimpinan_nama')->default('KH. Undang Ubaidillah');
            $table->string('pimpinan_jabatan')->default('Pimpinan Umum');
            $table->string('pimpinan_ttd_path')->nullable(); // Path to signature image
            $table->string('logo_pondok_path')->nullable();
            $table->string('logo_pendidikan_path')->nullable();
            $table->timestamps();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->string('wali_kelas_ttd_path')->nullable(); // Path to wali kelas signature
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_settings');
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('wali_kelas_ttd_path');
        });
    }
};
