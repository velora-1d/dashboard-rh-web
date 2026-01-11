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
        Schema::create('talaran_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->string('bulan');
            $table->integer('tahun');
            $table->integer('minggu_1')->default(0);
            $table->integer('minggu_2')->default(0);
            $table->integer('minggu_3')->default(0);
            $table->integer('minggu_4')->default(0);
            $table->integer('jumlah')->default(0);
            $table->integer('tamat')->default(0);
            $table->integer('alfa')->default(0);
            $table->string('total')->nullable(); // format: "1x tamat + 35 bait/jajar"
            
            // Period fields
            $table->integer('jumlah_1_2')->default(0);
            $table->integer('jumlah_3_4')->default(0);
            $table->string('total_1_2')->nullable();
            $table->string('total_3_4')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for faster lookups
            $table->index(['santri_id', 'bulan', 'tahun']);
            $table->index('bulan');
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talaran_santri');
    }
};
