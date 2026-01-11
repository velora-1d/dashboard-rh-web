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
        Schema::table('nilai_santri', function (Blueprint $table) {
            $table->decimal('nilai_original', 5, 2)->nullable()->after('nilai_akhir')->comment('Original grade before compensation');
            $table->decimal('nilai_kompensasi', 5, 2)->default(0)->after('nilai_original')->comment('Compensation amount (+ or -)');
            $table->boolean('is_compensated')->default(false)->after('nilai_kompensasi')->comment('Whether this grade was compensated');
            $table->json('compensation_metadata')->nullable()->after('is_compensated')->comment('Compensation details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_santri', function (Blueprint $table) {
            $table->dropColumn(['nilai_original', 'nilai_kompensasi', 'is_compensated', 'compensation_metadata']);
        });
    }
};
