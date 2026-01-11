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
        Schema::table('ujian_mingguan', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('ujian_mingguan', 'jumlah_keikutsertaan')) {
                $table->integer('jumlah_keikutsertaan')->default(0)->after('minggu_4');
            }
            if (!Schema::hasColumn('ujian_mingguan', 'status')) {
                $table->enum('status', ['SAH', 'TIDAK SAH'])->default('TIDAK SAH')->after('jumlah_keikutsertaan');
            }
            if (!Schema::hasColumn('ujian_mingguan', 'nilai_hasil_mingguan')) {
                $table->decimal('nilai_hasil_mingguan', 5, 2)->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_mingguan', function (Blueprint $table) {
            $table->dropColumn(['jumlah_keikutsertaan', 'status', 'nilai_hasil_mingguan']);
        });
    }
};
