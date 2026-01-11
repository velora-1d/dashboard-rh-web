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
        Schema::dropIfExists('talaran_mingguan');
        Schema::dropIfExists('talaran'); // In case the singular table exists
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No turning back for cleanup
    }
};
