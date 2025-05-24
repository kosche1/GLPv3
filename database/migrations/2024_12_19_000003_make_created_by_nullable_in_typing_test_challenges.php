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
        // For SQLite, we need to recreate the table to modify the column
        if (Schema::hasTable('typing_test_challenges')) {
            // Create a temporary table with the correct structure
            Schema::create('typing_test_challenges_temp', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
                $table->integer('word_count')->default(25);
                $table->integer('time_limit')->default(60);
                $table->enum('test_mode', ['words', 'time'])->default('words');
                $table->integer('target_wpm')->default(30);
                $table->integer('target_accuracy')->default(85);
                $table->json('word_list')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('points_reward')->default(50);
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO typing_test_challenges_temp (id, title, difficulty, word_count, time_limit, test_mode, is_active, created_at, updated_at) SELECT id, title, difficulty, word_count, time_limit, test_mode, is_active, created_at, updated_at FROM typing_test_challenges');

            // Drop the old table
            Schema::dropIfExists('typing_test_challenges');

            // Rename the temporary table
            Schema::rename('typing_test_challenges_temp', 'typing_test_challenges');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive operation, so we won't implement the reverse
        // The original table structure would need to be recreated
    }
};
