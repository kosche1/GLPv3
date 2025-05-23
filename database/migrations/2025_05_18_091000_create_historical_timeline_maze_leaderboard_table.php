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
        Schema::create('historical_timeline_maze_leaderboard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('historical_timeline_maze_id')->constrained()->onDelete('cascade');
            $table->string('era'); // ancient, medieval, renaissance, modern, contemporary
            $table->string('difficulty'); // easy, medium, hard
            $table->integer('score');
            $table->integer('time_taken'); // in seconds
            $table->float('accuracy')->default(0); // percentage
            $table->string('username')->nullable(); // For display purposes
            $table->string('avatar')->nullable(); // For display purposes
            $table->integer('rank')->default(0);
            $table->timestamps();

            // Add indexes for faster leaderboard queries
            $table->index(['era', 'difficulty', 'score', 'time_taken']);
            $table->index(['user_id', 'era', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_timeline_maze_leaderboard');
    }
};
