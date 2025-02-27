<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("daily_reward_tiers", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("day_number");
            $table->integer("points_reward");
            $table->string("reward_type")->nullable(); // 'points', 'badge', 'item', etc.
            $table->json("reward_data")->nullable(); // For additional reward data
            $table->timestamps();
        });
        Schema::create("user_daily_rewards", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("daily_reward_tier_id")
                ->constrained()
                ->onDelete("cascade");
            $table->timestamp("claimed_at");
            $table->date("streak_date");
            $table->integer("current_streak");
            $table->timestamps();
        });

        Schema::create("badges", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("image")->nullable();
            $table->string("trigger_type"); // 'achievement', 'level', 'points', 'task', 'referral'
            $table->json("trigger_conditions"); // JSON with trigger specifics
            $table->integer("rarity_level")->default(1); // 1-5 for common to legendary
            $table->boolean("is_hidden")->default(false);
            $table->timestamps();
        });
        Schema::create("user_badges", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("badge_id")->constrained()->onDelete("cascade");
            $table->timestamp("earned_at");
            $table->boolean("is_pinned")->default(false);
            $table->boolean("is_showcased")->default(false);
            $table->timestamps();
        });
        Schema::create("referral_programs", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->integer("referrer_points"); // Points earned by referrer
            $table->integer("referee_points"); // Points earned by new user
            $table->boolean("is_active")->default(true);
            $table->json("additional_rewards")->nullable(); // For any other rewards
            $table->timestamps();
        });
        Schema::create("referrals", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("referrer_id")
                ->constrained("users")
                ->onDelete("cascade");
            $table
                ->foreignId("referee_id")
                ->constrained("users")
                ->onDelete("cascade");
            $table
                ->foreignId("referral_program_id")
                ->constrained()
                ->onDelete("cascade");
            $table->string("referral_code")->unique();
            $table
                ->enum("status", ["pending", "completed", "rewarded"])
                ->default("pending");
            $table->timestamp("completed_at")->nullable();
            $table->boolean("referrer_rewarded")->default(false);
            $table->boolean("referee_rewarded")->default(false);
            $table->timestamps();
        });
        Schema::create("tasks", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->integer("points_reward");
            $table->enum("type", [
                "daily",
                "weekly",
                "onetime",
                "repeatable",
                "challenge",
            ]);
            $table->boolean("is_active")->default(true);
            $table->json("completion_criteria"); // Defines how to complete the task
            $table->json("additional_rewards")->nullable(); // For any other rewards
            $table->timestamps();
        });
        Schema::create("user_tasks", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("task_id")->constrained()->onDelete("cascade");
            $table->integer("progress")->default(0);
            $table->boolean("completed")->default(false);
            $table->timestamp("completed_at")->nullable();
            $table->boolean("reward_claimed")->default(false);
            $table->timestamp("reward_claimed_at")->nullable();
            $table->timestamps();
        });
        Schema::create("rewards", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("type"); // 'points', 'badge', 'item', 'currency', etc.
            $table->json("reward_data"); // Contents of the reward
            $table->timestamps();
        });
        Schema::create("user_rewards", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("reward_id")->constrained()->onDelete("cascade");
            $table->morphs("source"); // For polymorphic relationship (task, achievement, etc.)
            $table->timestamp("earned_at");
            $table->boolean("is_claimed")->default(false);
            $table->timestamp("claimed_at")->nullable();
            $table->timestamps();
        });
        Schema::create("leaderboard_categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->string("metric"); // 'points', 'achievements', 'streak', etc.
            $table
                ->enum("timeframe", ["daily", "weekly", "monthly", "alltime"])
                ->default("alltime");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
        Schema::create("leaderboard_entries", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("leaderboard_category_id")
                ->constrained()
                ->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->bigInteger("score");
            $table->integer("rank")->nullable();
            $table->dateTime("period_start")->nullable();
            $table->dateTime("period_end")->nullable();
            $table->timestamps();

            $table->unique([
                "leaderboard_category_id",
                "user_id",
                "period_start",
                "period_end",
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tables");
    }
};
