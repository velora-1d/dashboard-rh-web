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
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->enum('jenis', ['Quran', 'Kitab']);
            $table->string('nama_hafalan'); // e.g. "Juz 30" or "Kitab Jurumiyah"
            $table->string('progress'); // e.g. "Surat An-Naba 1-10"
            $table->date('tanggal');
            $table->integer('nilai')->nullable(); // 0-100
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // Ustadz/Pendidikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan');
    }
};
