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
        // SQLite doesn't support changing columns directly with Check constraints easily via Blueprint
        // without doctrine/dbal. 
        // We will use a raw query to drop the constraint if possible, but Laravel's Schema builder
        // with sqlite often requires the table to be copied.
        // However, standard modifying to string might work if we accept the potential complex migration
        
        // Simpler approach for SQLite: Just act as if we are making it a string, 
        // effectively removing the enum constraint validation on the DB level.
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            $table->string('kategori')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            //
        });
    }
};
