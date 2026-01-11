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
        Schema::create('gaji_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->decimal('nominal', 15, 2);
            $table->boolean('is_dibayar')->default(false);
            $table->date('tanggal_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['pegawai_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_pegawai');
    }
};
