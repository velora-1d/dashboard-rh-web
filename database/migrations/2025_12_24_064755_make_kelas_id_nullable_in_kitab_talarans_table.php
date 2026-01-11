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
        // For MySQL, we can simply modify the column
        Schema::table('kitab_talarans', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['kelas_id']);
            
            // Modify column to be nullable
            $table->unsignedBigInteger('kelas_id')->nullable()->change();
            
            // Re-add the foreign key
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore non-nullable constraint (same process in reverse)
        Schema::rename('kitab_talarans', 'kitab_talarans_new');
        
        Schema::create('kitab_talarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->integer('semester');
            $table->string('nama_kitab');
            $table->timestamps();
            
            $table->unique(['kelas_id', 'semester']);
        });
        
        // Copy back only non-null records
        DB::statement('INSERT INTO kitab_talarans (id, kelas_id, semester, nama_kitab, created_at, updated_at) SELECT id, kelas_id, semester, nama_kitab, created_at, updated_at FROM kitab_talarans_new WHERE kelas_id IS NOT NULL');
        
        Schema::dropIfExists('kitab_talarans_new');
    }
};
