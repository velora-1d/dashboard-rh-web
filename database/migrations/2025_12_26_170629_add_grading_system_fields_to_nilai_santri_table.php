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
            // Rename nilai_uts to nilai_ujian_semester for clarity
            $table->renameColumn('nilai_uts', 'nilai_ujian_semester');
            
            // Add nilai_asli for ranking (actual academic ability, can be < 5)
            $table->decimal('nilai_asli', 5, 2)->nullable()->after('nilai_akhir')
                ->comment('Actual score for ranking (can be below 5)');
            
            // Add nilai_rapor for report cards (administrative, minimum 5)
            $table->decimal('nilai_rapor', 5, 2)->nullable()->after('nilai_asli')
                ->comment('Report card score (minimum 5 for administrative purposes)');
            
            // Add source tracking for transparency
            $table->enum('source_type', ['semester', 'weekly', 'merged_weekly_better', 'merged_semester_better'])
                ->default('semester')->after('nilai_rapor')
                ->comment('Source of final score');
            
            // Add metadata for full transparency
            $table->json('source_metadata')->nullable()->after('source_type')
                ->comment('Details: weekly_score, semester_score, weekly_status, reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_santri', function (Blueprint $table) {
            $table->renameColumn('nilai_ujian_semester', 'nilai_uts');
            $table->dropColumn(['nilai_asli', 'nilai_rapor', 'source_type', 'source_metadata']);
        });
    }
};
