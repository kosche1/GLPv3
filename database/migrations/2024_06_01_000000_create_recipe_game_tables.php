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
        // Ingredients table
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // e.g., protein, vegetable, grain, dairy, etc.
            $table->string('image_path')->nullable();
            $table->integer('calories_per_serving');
            $table->decimal('protein_grams', 8, 2)->default(0);
            $table->decimal('carbs_grams', 8, 2)->default(0);
            $table->decimal('fat_grams', 8, 2)->default(0);
            $table->decimal('fiber_grams', 8, 2)->default(0);
            $table->decimal('sugar_grams', 8, 2)->default(0);
            $table->decimal('sodium_mg', 8, 2)->default(0);
            $table->timestamps();
        });

        // Recipe templates (for challenges)
        Schema::create('recipe_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('difficulty_level'); // beginner, intermediate, advanced
            $table->integer('target_calories_min');
            $table->integer('target_calories_max');
            $table->decimal('target_protein_min', 8, 2)->nullable();
            $table->decimal('target_carbs_min', 8, 2)->nullable();
            $table->decimal('target_fat_min', 8, 2)->nullable();
            $table->decimal('target_protein_max', 8, 2)->nullable();
            $table->decimal('target_carbs_max', 8, 2)->nullable();
            $table->decimal('target_fat_max', 8, 2)->nullable();
            $table->json('required_categories')->nullable(); // e.g., must include protein, vegetable
            $table->json('required_ingredients')->nullable(); // specific ingredients that must be included
            $table->json('forbidden_ingredients')->nullable(); // ingredients that cannot be used
            $table->integer('max_ingredients')->default(10);
            $table->integer('points_reward')->default(100);
            $table->timestamps();
        });

        // User created recipes
        Schema::create('user_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_template_id')->nullable()->constrained('recipe_templates')->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('total_calories');
            $table->decimal('total_protein', 8, 2);
            $table->decimal('total_carbs', 8, 2);
            $table->decimal('total_fat', 8, 2);
            $table->boolean('is_balanced')->default(false);
            $table->boolean('meets_requirements')->default(false);
            $table->integer('score')->default(0);
            $table->timestamps();
        });

        // Recipe ingredients (junction table)
        Schema::create('user_recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_ingredient_id')->constrained('recipe_ingredients')->onDelete('cascade');
            $table->integer('quantity')->default(1); // number of servings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_recipe_ingredients');
        Schema::dropIfExists('user_recipes');
        Schema::dropIfExists('recipe_templates');
        Schema::dropIfExists('recipe_ingredients');
    }
};
