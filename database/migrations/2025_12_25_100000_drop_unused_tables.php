<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drop unused/obsolete tables to clean up the database.
     */
    public function up(): void
    {
        // First drop tables that have foreign keys to other tables we're dropping
        Schema::dropIfExists('pelajaran');  // Has FK to guru, must drop first
        
        // Then drop tables whose models have been deleted
        Schema::dropIfExists('file_manager');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('rapot');
        Schema::dropIfExists('tajiran_mingguan');
        
        // Old/superseded tables
        Schema::dropIfExists('absensi');    // Use absensi_santri instead
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // These tables are intentionally not recreated in down()
        // as they are obsolete and should not be restored
    }
};
