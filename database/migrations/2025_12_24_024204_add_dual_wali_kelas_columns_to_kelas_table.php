<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('tipe_wali_kelas', ['tunggal', 'dual'])->default('tunggal')->after('wali_kelas_ttd_path');
            $table->string('wali_kelas_putra')->nullable()->after('tipe_wali_kelas');
            $table->string('wali_kelas_putri')->nullable()->after('wali_kelas_putra');
            $table->string('wali_kelas_ttd_path_putra')->nullable()->after('wali_kelas_putri');
            $table->string('wali_kelas_ttd_path_putri')->nullable()->after('wali_kelas_ttd_path_putra');
        });

        // Set Default Dual Classes
        $dualClasses = ['1 Ibtida', '2 Ibtida', '3 Ibtida', '1 Tsanawi'];
        DB::table('kelas')->whereIn('nama_kelas', $dualClasses)->update(['tipe_wali_kelas' => 'dual']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_wali_kelas', 
                'wali_kelas_putra', 
                'wali_kelas_putri', 
                'wali_kelas_ttd_path_putra', 
                'wali_kelas_ttd_path_putri'
            ]);
        });
    }
};
