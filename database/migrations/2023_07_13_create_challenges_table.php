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
        if (!Schema::hasTable('challenges')) {
            Schema::create('challenges', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->dateTime('start_date');
                $table->dateTime('end_date')->nullable();
                $table->integer('points_reward')->default(0);
                $table->string('difficulty_level')->default('intermediate');
                $table->boolean('is_active')->default(true);
                $table->integer('max_participants')->nullable();
                $table->json('completion_criteria')->nullable();
                $table->json('additional_rewards')->nullable();
                $table->integer('required_level')->default(1);
                $table->string('challenge_type')->default('coding_challenge');
                $table->string('programming_language')->nullable();
                $table->string('tech_category')->default('general');
                $table->string('subject_type')->nullable()->comment('core, applied, specialized');
                $table->foreignId('strand_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('subject_type_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
                $table->integer('time_limit')->nullable();
                $table->json('challenge_content')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
