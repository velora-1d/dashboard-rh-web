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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('log_name')->default('default');
            $table->text('description');
            $table->string('subject_type')->nullable(); // Model class name (e.g., App\Models\Santri)
            $table->unsignedBigInteger('subject_id')->nullable(); // Model ID
            $table->string('causer_type')->nullable(); // Who caused this (usually User)
            $table->unsignedBigInteger('causer_id')->nullable();
            $table->json('properties')->nullable(); // Old and new values
            $table->string('event')->nullable(); // created, updated, deleted
            $table->timestamps();
            
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
            $table->index('log_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
