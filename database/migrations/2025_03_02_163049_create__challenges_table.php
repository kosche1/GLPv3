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
        if (!Schema::hasTable('challenges')) {
            Schema::create("challenges", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->dateTime("start_date");
            $table->dateTime("end_date")->nullable();
            $table->integer("points_reward")->default(0);
            $table->string("difficulty_level")->default("intermediate"); // beginner, intermediate, advanced, expert
            $table->boolean("is_active")->default(true);
            $table->integer("max_participants")->nullable();
            $table->json("completion_criteria")->nullable();
            $table->json("additional_rewards")->nullable();
            $table->integer("required_level")->default(1);

            // IT-focused challenge types
            $table->string("challenge_type")->default("coding_challenge"); // coding_challenge, debugging, algorithm, quiz, flashcard, project, code_review, database, security, ui_design
            $table->string("programming_language")->nullable(); // python, javascript, java, csharp, cpp, php, ruby, swift, go, sql, multiple, none
            $table->string("tech_category")->default("general"); // web_dev, mobile_dev, data_science, devops, cloud, security, ai_ml, databases, networking, blockchain, game_dev, iot, general
            $table->integer("time_limit")->nullable(); // Time limit in minutes
            $table->json("challenge_content")->nullable(); // Structured content based on the challenge type
            $table->timestamps();
        });
        }

        if (!Schema::hasTable('user_challenges')) {
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
            $table->json("submission_data")->nullable(); // Store code submissions, answers, etc.
            $table->timestamps();

            $table->unique(["user_id", "challenge_id"]);
        });
        }

        // For challenge-badge relationship
        if (!Schema::hasTable('challenge_badges')) {
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
        }

        // For challenge-achievement relationship
        if (!Schema::hasTable('challenge_achievements')) {
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
        }

        // For challenge-activity relationship
        if (!Schema::hasTable('challenge_activities')) {
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

        // For challenge submissions and feedback
        if (!Schema::hasTable('challenge_submissions')) {
            Schema::create("challenge_submissions", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("challenge_id")->constrained()->onDelete("cascade");
            $table->json("submission_content"); // Code, answers, files, etc.
            $table->string("status")->default("submitted"); // submitted, reviewed, approved, rejected
            $table->text("feedback")->nullable(); // Instructor feedback
            $table->integer("score")->nullable();
            $table->timestamps();

            $table->unique(["user_id", "challenge_id", "created_at"]);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("challenge_submissions");
        Schema::dropIfExists("challenge_activities");
        Schema::dropIfExists("challenge_achievements");
        Schema::dropIfExists("challenge_badges");
        Schema::dropIfExists("user_challenges");
        Schema::dropIfExists("challenges");
    }
};
