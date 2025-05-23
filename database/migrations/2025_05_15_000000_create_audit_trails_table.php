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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action_type'); // registration, challenge_completion, task_submission, etc.
            $table->string('subject_type')->nullable(); // Core, Applied, Specialized
            $table->string('subject_name')->nullable(); // Python, Math, etc.
            $table->string('challenge_name')->nullable();
            $table->string('task_name')->nullable();
            $table->integer('score')->nullable();
            $table->text('description');
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
