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
        Schema::create("challenges", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->dateTime("start_date");
            $table->dateTime("end_date")->nullable();
            $table->integer("points_reward")->default(0);
            $table->string("difficulty_level")->default("medium"); // easy, medium, hard, expert
            $table->boolean("is_active")->default(true);
            $table->integer("max_participants")->nullable();
            $table->json("completion_criteria")->nullable();
            $table->json("additional_rewards")->nullable();
            $table->integer("required_level")->default(1);
            $table->timestamps();
        });
        Schema::create("user_challenges", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("challenge_id")
                ->constrained()
                ->onDelete("cascade");
            $table->string("status")->default("enrolled"); // enrolled, in_progress, completed, failed
            $table->integer("progress")->default(0);
            $table->dateTime("completed_at")->nullable();
            $table->boolean("reward_claimed")->default(false);
            $table->dateTime("reward_claimed_at")->nullable();
            $table->integer("attempts")->default(0);
            $table->timestamps();

            $table->unique(["user_id", "challenge_id"]);
        });
        // For challenge-badge relationship
        Schema::create("challenge_badges", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("challenge_id")
                ->constrained()
                ->onDelete("cascade");
            $table->foreignId("badge_id")->constrained()->onDelete("cascade");
            $table->timestamps();

            $table->unique(["challenge_id", "badge_id"]);
        });

        // For challenge-achievement relationship
        Schema::create("challenge_achievements", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("challenge_id")
                ->constrained()
                ->onDelete("cascade");
            $table
                ->foreignId("achievement_id")
                ->constrained()
                ->onDelete("cascade");
            $table->timestamps();

            $table->unique(["challenge_id", "achievement_id"]);
        });

        // For challenge-activity relationship
        Schema::create("challenge_activities", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("challenge_id")
                ->constrained()
                ->onDelete("cascade");
            $table
                ->foreignId("activity_id")
                ->constrained()
                ->onDelete("cascade");
            $table->integer("required_count")->default(1);
            $table->timestamps();

            $table->unique(["challenge_id", "activity_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("_challenges");
    }
};
