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
        Schema::create('chemistry_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('points_reward')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('challenge_data'); // Experiment details, chemicals, equipment
            $table->json('expected_result')->nullable(); // Expected outcome
            $table->integer('time_limit')->nullable(); // Time limit in minutes
            $table->text('instructions')->nullable();
            $table->json('hints')->nullable(); // Array of hints
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemistry_challenges');
    }
};
