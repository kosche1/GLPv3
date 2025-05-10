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
        Schema::create('user_chemistry_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chemistry_challenge_id')->constrained('chemistry_challenges')->onDelete('cascade');
            $table->json('user_solution'); // User's solution data
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->text('notes')->nullable(); // User's notes about their solution
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Ensure a user can only have one attempt per challenge
            $table->unique(['user_id', 'chemistry_challenge_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chemistry_attempts');
    }
};
