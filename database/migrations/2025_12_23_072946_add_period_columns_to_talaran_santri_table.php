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
        Schema::table('talaran_santri', function (Blueprint $table) {
            $table->integer('tamat_1_2')->default(0)->after('minggu_2');
            $table->integer('alfa_1_2')->default(0)->after('tamat_1_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talaran_santri', function (Blueprint $table) {
            $table->dropColumn(['tamat_1_2', 'alfa_1_2']);
        });
    }
};
