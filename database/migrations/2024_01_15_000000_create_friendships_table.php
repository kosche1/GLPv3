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
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'blocked'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamps();

            // Ensure unique friendship pairs
            $table->unique(['user_id', 'friend_id']);

            // Add indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['friend_id', 'status']);
        });

        // Create friend activities table
        Schema::create('friend_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('activity_type'); // 'challenge_completed', 'badge_earned', 'level_up', etc.
            $table->string('activity_title');
            $table->text('activity_description')->nullable();
            $table->json('activity_data')->nullable(); // Store additional data
            $table->integer('points_earned')->default(0);
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['activity_type', 'created_at']);
            $table->index(['is_public', 'created_at']);
        });

        // Create activity likes table
        Schema::create('activity_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_activity_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'friend_activity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_likes');
        Schema::dropIfExists('friend_activities');
        Schema::dropIfExists('friendships');
    }
};
