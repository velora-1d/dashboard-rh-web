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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // e.g., "1 Ibtida", "2 Tsanawi", "1 Ma'had Aly", "Pengabdian"
            $table->string('tingkat'); // e.g., "Ibtida", "Tsanawi", "Ma'had Aly", "Pengabdian"
            $table->integer('level')->nullable(); // 1, 2, 3, 4 (null for Pengabdian)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
