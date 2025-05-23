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
        // Skip if the table already exists
        if (!Schema::hasTable('user_investment_challenges')) {
            Schema::create('user_investment_challenges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('investment_challenge_id')->constrained()->onDelete('cascade');
                $table->enum('status', ['in-progress', 'completed', 'submitted', 'graded'])->default('in-progress');
                $table->integer('progress')->default(0)->comment('Progress percentage (0-100)');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->dateTime('submitted_at')->nullable();
                $table->text('strategy')->nullable()->comment('User\'s investment strategy');
                $table->text('learnings')->nullable()->comment('User\'s learnings from the challenge');
                $table->integer('grade')->nullable()->comment('Grade given by teacher (0-100)');
                $table->text('feedback')->nullable()->comment('Teacher feedback');
                $table->timestamps();

                // Ensure a user can only have one active instance of each challenge
                $table->unique(['user_id', 'investment_challenge_id']);
            });
        } else {
            // If the table exists, check if we need to update the schema
            Schema::table('user_investment_challenges', function (Blueprint $table) {
                // Add any missing columns if needed
                if (!Schema::hasColumn('user_investment_challenges', 'progress')) {
                    $table->integer('progress')->default(0)->comment('Progress percentage (0-100)');
                }

                if (!Schema::hasColumn('user_investment_challenges', 'grade')) {
                    $table->integer('grade')->nullable()->comment('Grade given by teacher (0-100)');
                }

                // Add more column checks as needed
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investment_challenges');
    }
};
