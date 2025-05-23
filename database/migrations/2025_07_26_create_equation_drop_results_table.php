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
        if (!Schema::hasTable('equation_drop_results')) {
            Schema::create('equation_drop_results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('equation_drop_id')->constrained('equation_drops')->onDelete('cascade');
                $table->string('difficulty')->comment('easy, medium, or hard');
                $table->integer('score')->comment('Total score achieved');
                $table->integer('questions_attempted')->comment('Number of questions attempted');
                $table->integer('questions_correct')->comment('Number of questions answered correctly');
                $table->decimal('accuracy_percentage', 5, 2)->comment('Percentage of correct answers');
                $table->integer('time_spent_seconds')->comment('Total time spent in seconds');
                $table->boolean('completed')->default(false)->comment('Whether the game was completed');
                $table->text('notes')->nullable()->comment('User notes about the game');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equation_drop_results');
    }
};
