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
        // Create study groups table
        Schema::create('study_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_private')->default(false);
            $table->string('join_code')->nullable()->unique();
            $table->integer('max_members')->default(10);
            $table->json('focus_areas')->nullable();
            $table->timestamps();
        });

        // Create pivot table for users and study groups
        Schema::create('study_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['member', 'moderator', 'leader'])->default('member');
            $table->timestamp('joined_at');
            $table->timestamps();
            
            // Ensure a user can only be in a group once
            $table->unique(['study_group_id', 'user_id']);
        });

        // Create group challenges table
        Schema::create('group_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('study_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('points_reward')->default(0);
            $table->integer('difficulty_level')->default(1);
            $table->boolean('is_active')->default(true);
            $table->string('completion_criteria')->nullable();
            $table->json('additional_rewards')->nullable();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('challenge_type')->nullable();
            $table->integer('time_limit')->nullable();
            $table->text('challenge_content')->nullable();
            $table->timestamps();
        });

        // Create group challenge tasks table
        Schema::create('group_challenge_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_challenge_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('points_reward')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('answer_key')->nullable();
            $table->json('expected_output')->nullable();
            $table->timestamps();
        });

        // Create user group challenge progress table
        Schema::create('user_group_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_challenge_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'expired'])->default('not_started');
            $table->integer('progress')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->boolean('reward_claimed')->default(false);
            $table->timestamp('reward_claimed_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamps();
            
            // Ensure a user can only have one progress record per group challenge
            $table->unique(['user_id', 'group_challenge_id']);
        });

        // Create group discussions table
        Schema::create('group_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        // Create group discussion comments table
        Schema::create('group_discussion_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_discussion_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->foreignId('parent_id')->nullable()->constrained('group_discussion_comments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_discussion_comments');
        Schema::dropIfExists('group_discussions');
        Schema::dropIfExists('user_group_challenges');
        Schema::dropIfExists('group_challenge_tasks');
        Schema::dropIfExists('group_challenges');
        Schema::dropIfExists('study_group_user');
        Schema::dropIfExists('study_groups');
    }
};
