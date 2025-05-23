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
        Schema::create('historical_timeline_maze_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('historical_timeline_maze_id')->constrained()->onDelete('cascade');
            $table->string('era'); // ancient, medieval, renaissance, modern, contemporary
            $table->string('difficulty'); // easy, medium, hard
            $table->integer('score');
            $table->integer('time_taken'); // in seconds
            $table->integer('questions_answered');
            $table->integer('correct_answers');
            $table->float('accuracy')->default(0); // percentage
            $table->integer('max_streak');
            $table->json('answers')->nullable(); // Store the user's answers
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_timeline_maze_progress');
    }
};
