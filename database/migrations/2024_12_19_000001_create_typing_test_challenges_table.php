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
        Schema::create('typing_test_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('word_count')->default(25)->comment('Number of words for word-based tests');
            $table->integer('time_limit')->default(60)->comment('Time limit in seconds for time-based tests');
            $table->enum('test_mode', ['words', 'time'])->default('words');
            $table->integer('target_wpm')->default(30)->comment('Target words per minute');
            $table->integer('target_accuracy')->default(85)->comment('Target accuracy percentage');
            $table->json('word_list')->nullable()->comment('Custom word list, null for default');
            $table->boolean('is_active')->default(true);
            $table->integer('points_reward')->default(50);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index(['difficulty', 'is_active']);
            $table->index(['test_mode', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_test_challenges');
    }
};
