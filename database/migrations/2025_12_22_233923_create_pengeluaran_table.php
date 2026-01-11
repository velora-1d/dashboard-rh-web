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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pengeluaran');
            $table->date('tanggal');
            $table->decimal('nominal', 15, 2);
            $table->text('keterangan')->nullable();
            $table->string('kategori')->nullable(); // Operasional, Gaji, Pemeliharaan, Lainnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
