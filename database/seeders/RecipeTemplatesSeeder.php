<?php

namespace Database\Seeders;

use App\Models\RecipeTemplate;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get ingredient IDs by name for required/forbidden ingredients
        $chickenId = RecipeIngredient::where('name', 'Chicken Breast')->first()?->id;
        $tofuId = RecipeIngredient::where('name', 'Tofu')->first()?->id;
        $beefId = RecipeIngredient::where('name', 'Beef')->first()?->id;
        $salmonId = RecipeIngredient::where('name', 'Salmon')->first()?->id;

        // Define recipe templates (challenges)
        $templates = [
            [
                'name' => 'Balanced Breakfast',
                'description' => 'Create a nutritious breakfast that provides energy for the day. Include a good balance of protein, carbs, and healthy fats.',
                'difficulty_level' => 'beginner',
                'target_calories_min' => 400,
                'target_calories_max' => 600,
                'target_protein_min' => 15,
                'target_carbs_min' => 45,
                'target_fat_min' => 10,
                'target_protein_max' => 30,
                'target_carbs_max' => 75,
                'target_fat_max' => 25,
                'required_categories' => ['protein', 'grain'],
                'required_ingredients' => null,
                'forbidden_ingredients' => null,
                'max_ingredients' => 6,
                'points_reward' => 100,
            ],
            [
                'name' => 'Vegetarian Lunch',
                'description' => 'Create a satisfying vegetarian lunch that provides adequate protein without meat.',
                'difficulty_level' => 'beginner',
                'target_calories_min' => 500,
                'target_calories_max' => 700,
                'target_protein_min' => 20,
                'target_carbs_min' => 60,
                'target_fat_min' => 15,
                'target_protein_max' => 35,
                'target_carbs_max' => 90,
                'target_fat_max' => 30,
                'required_categories' => ['vegetable'],
                'required_ingredients' => [$tofuId],
                'forbidden_ingredients' => [$chickenId, $beefId, $salmonId],
                'max_ingredients' => 8,
                'points_reward' => 150,
            ],
            [
                'name' => 'High-Protein Dinner',
                'description' => 'Create a dinner focused on protein for muscle recovery and growth.',
                'difficulty_level' => 'intermediate',
                'target_calories_min' => 600,
                'target_calories_max' => 800,
                'target_protein_min' => 40,
                'target_carbs_min' => 50,
                'target_fat_min' => 15,
                'target_protein_max' => 60,
                'target_carbs_max' => 80,
                'target_fat_max' => 30,
                'required_categories' => ['protein', 'vegetable'],
                'required_ingredients' => null,
                'forbidden_ingredients' => null,
                'max_ingredients' => 7,
                'points_reward' => 200,
            ],
            [
                'name' => 'Heart-Healthy Meal',
                'description' => 'Create a meal that promotes cardiovascular health with lean proteins and healthy fats.',
                'difficulty_level' => 'intermediate',
                'target_calories_min' => 500,
                'target_calories_max' => 700,
                'target_protein_min' => 25,
                'target_carbs_min' => 50,
                'target_fat_min' => 15,
                'target_protein_max' => 40,
                'target_carbs_max' => 75,
                'target_fat_max' => 25,
                'required_categories' => ['protein', 'vegetable', 'fat'],
                'required_ingredients' => [$salmonId],
                'forbidden_ingredients' => [$beefId],
                'max_ingredients' => 8,
                'points_reward' => 200,
            ],
            [
                'name' => 'Budget-Friendly Meal',
                'description' => 'Create a nutritious meal using cost-effective ingredients.',
                'difficulty_level' => 'beginner',
                'target_calories_min' => 500,
                'target_calories_max' => 700,
                'target_protein_min' => 20,
                'target_carbs_min' => 60,
                'target_fat_min' => 10,
                'target_protein_max' => 35,
                'target_carbs_max' => 90,
                'target_fat_max' => 25,
                'required_categories' => ['protein', 'vegetable', 'grain'],
                'required_ingredients' => null,
                'forbidden_ingredients' => [$salmonId], // Salmon is expensive
                'max_ingredients' => 6,
                'points_reward' => 150,
            ],
        ];

        // Insert all templates
        foreach ($templates as $template) {
            RecipeTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }

        $this->command->info('Recipe templates seeded successfully!');
    }
}
