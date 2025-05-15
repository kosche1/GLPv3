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
        Schema::create('historical_timeline_maze_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historical_timeline_maze_id')->constrained()->onDelete('cascade');
            $table->string('era'); // ancient, medieval, renaissance, modern, contemporary
            $table->string('difficulty')->default('easy'); // easy, medium, hard
            $table->string('question');
            $table->json('options'); // JSON array of answer options with id, title, year, correct
            $table->string('hint')->nullable();
            $table->integer('points')->default(100); // Points value for this question
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_timeline_maze_questions');
    }
};
