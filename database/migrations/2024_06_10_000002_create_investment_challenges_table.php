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
        // Only create the table if it doesn't exist
        if (!Schema::hasTable('investment_challenges')) {
            Schema::create('investment_challenges', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('difficulty')->default('beginner');
                $table->decimal('starting_capital', 12, 2)->default(100000.00);
                $table->decimal('target_return', 8, 2)->default(10.00);
                $table->integer('duration_days')->default(30);
                $table->integer('points_reward')->default(100);
                $table->boolean('is_active')->default(true);
                $table->json('required_stocks')->nullable();
                $table->json('forbidden_stocks')->nullable();
                $table->timestamps();
            });
        }

        // Only create the table if it doesn't exist
        if (!Schema::hasTable('user_investment_challenges')) {
            Schema::create('user_investment_challenges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('investment_challenge_id')->constrained()->onDelete('cascade');
                $table->string('status')->default('in_progress');
                $table->decimal('progress', 5, 2)->default(0.00);
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->text('strategy')->nullable();
                $table->text('learnings')->nullable();
                $table->string('grade')->nullable();
                $table->text('feedback')->nullable();
                $table->boolean('points_awarded')->default(false);
                $table->timestamp('points_awarded_at')->nullable();
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investment_challenges');
        Schema::dropIfExists('investment_challenges');
    }
};
