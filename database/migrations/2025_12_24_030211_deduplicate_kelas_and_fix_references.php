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
        // Get all duplicate classes
        $duplicates = DB::table('kelas')
            ->select('nama_kelas', DB::raw('COUNT(*) as count'))
            ->groupBy('nama_kelas')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            // Get all IDs for this class name
            $ids = DB::table('kelas')
                ->where('nama_kelas', $dup->nama_kelas)
                ->orderBy('id', 'asc') // Keep the oldest one (Master)
                ->pluck('id')
                ->toArray();

            $masterId = $ids[0];
            $duplicateIds = array_slice($ids, 1);

            // Reassign dependencies to Master ID
            // Santri
            DB::table('santri')
                ->whereIn('kelas_id', $duplicateIds)
                ->update(['kelas_id' => $masterId]);

            // Jadwal Pelajaran
            DB::table('jadwal_pelajaran')
                ->whereIn('kelas_id', $duplicateIds)
                ->update(['kelas_id' => $masterId]);

            // Absensi Santri
            DB::table('absensi_santri')
                ->whereIn('kelas_id', $duplicateIds)
                ->update(['kelas_id' => $masterId]);
                
            // Nilai Santri (Assuming related via Santri, but if explicit kelas_id exists in future, handle here)
            // No direct kelas_id column in current nilai_santri migration, linked via santri_id.
            
            // Delete duplicates
            DB::table('kelas')->whereIn('id', $duplicateIds)->delete();
        }

        // Re-apply Dual Status ensuring standard consistency
        $dualClasses = ['1 Ibtida', '2 Ibtida', '3 Ibtida', '1 Tsanawi'];
        DB::table('kelas')
            ->whereIn('nama_kelas', $dualClasses)
            ->update(['tipe_wali_kelas' => 'dual']);
            
        // Ensure others are single
        DB::table('kelas')
            ->whereNotIn('nama_kelas', $dualClasses)
            ->update(['tipe_wali_kelas' => 'tunggal']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot revert deduplication easily without backups
    }
};
