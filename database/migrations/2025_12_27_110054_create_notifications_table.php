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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // payment, santri, nilai, system
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data as JSON
            $table->string('icon')->default('bell');
            $table->string('color')->default('#3b82f6');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('role')->nullable(); // Target role: admin, pendidikan, sekretaris, bendahara
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
