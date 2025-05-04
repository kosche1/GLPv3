<?php

namespace Database\Seeders;

use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Proteins
        $proteins = [
            [
                'name' => 'Chicken Breast',
                'category' => 'protein',
                'image_path' => 'images/recipe-game/ingredients/chicken-breast.png',
                'calories_per_serving' => 165,
                'protein_grams' => 31.0,
                'carbs_grams' => 0.0,
                'fat_grams' => 3.6,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.0,
                'sodium_mg' => 74.0,
            ],
            [
                'name' => 'Salmon',
                'category' => 'protein',
                'image_path' => 'images/recipe-game/ingredients/salmon.png',
                'calories_per_serving' => 206,
                'protein_grams' => 22.0,
                'carbs_grams' => 0.0,
                'fat_grams' => 13.0,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.0,
                'sodium_mg' => 59.0,
            ],
            [
                'name' => 'Tofu',
                'category' => 'protein',
                'image_path' => 'images/recipe-game/ingredients/tofu.png',
                'calories_per_serving' => 94,
                'protein_grams' => 10.0,
                'carbs_grams' => 2.3,
                'fat_grams' => 6.0,
                'fiber_grams' => 0.5,
                'sugar_grams' => 0.7,
                'sodium_mg' => 9.0,
            ],
            [
                'name' => 'Eggs',
                'category' => 'protein',
                'image_path' => 'images/recipe-game/ingredients/eggs.png',
                'calories_per_serving' => 72,
                'protein_grams' => 6.3,
                'carbs_grams' => 0.4,
                'fat_grams' => 5.0,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.2,
                'sodium_mg' => 71.0,
            ],
            [
                'name' => 'Beef',
                'category' => 'protein',
                'image_path' => 'images/recipe-game/ingredients/beef.png',
                'calories_per_serving' => 250,
                'protein_grams' => 26.0,
                'carbs_grams' => 0.0,
                'fat_grams' => 17.0,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.0,
                'sodium_mg' => 72.0,
            ],
        ];

        // Vegetables
        $vegetables = [
            [
                'name' => 'Broccoli',
                'category' => 'vegetable',
                'image_path' => 'images/recipe-game/ingredients/broccoli.png',
                'calories_per_serving' => 55,
                'protein_grams' => 3.7,
                'carbs_grams' => 11.2,
                'fat_grams' => 0.6,
                'fiber_grams' => 5.1,
                'sugar_grams' => 2.6,
                'sodium_mg' => 33.0,
            ],
            [
                'name' => 'Spinach',
                'category' => 'vegetable',
                'image_path' => 'images/recipe-game/ingredients/spinach.png',
                'calories_per_serving' => 23,
                'protein_grams' => 2.9,
                'carbs_grams' => 3.6,
                'fat_grams' => 0.4,
                'fiber_grams' => 2.2,
                'sugar_grams' => 0.4,
                'sodium_mg' => 79.0,
            ],
            [
                'name' => 'Carrots',
                'category' => 'vegetable',
                'image_path' => 'images/recipe-game/ingredients/carrots.png',
                'calories_per_serving' => 50,
                'protein_grams' => 1.2,
                'carbs_grams' => 12.0,
                'fat_grams' => 0.3,
                'fiber_grams' => 3.6,
                'sugar_grams' => 6.1,
                'sodium_mg' => 69.0,
            ],
            [
                'name' => 'Bell Peppers',
                'category' => 'vegetable',
                'image_path' => 'images/recipe-game/ingredients/bell-peppers.png',
                'calories_per_serving' => 30,
                'protein_grams' => 1.0,
                'carbs_grams' => 7.0,
                'fat_grams' => 0.2,
                'fiber_grams' => 2.1,
                'sugar_grams' => 4.2,
                'sodium_mg' => 4.0,
            ],
            [
                'name' => 'Tomatoes',
                'category' => 'vegetable',
                'image_path' => 'images/recipe-game/ingredients/tomatoes.png',
                'calories_per_serving' => 22,
                'protein_grams' => 1.1,
                'carbs_grams' => 4.8,
                'fat_grams' => 0.2,
                'fiber_grams' => 1.5,
                'sugar_grams' => 3.2,
                'sodium_mg' => 6.0,
            ],
        ];

        // Grains
        $grains = [
            [
                'name' => 'Brown Rice',
                'category' => 'grain',
                'image_path' => 'images/recipe-game/ingredients/brown-rice.png',
                'calories_per_serving' => 216,
                'protein_grams' => 5.0,
                'carbs_grams' => 45.0,
                'fat_grams' => 1.8,
                'fiber_grams' => 3.5,
                'sugar_grams' => 0.7,
                'sodium_mg' => 10.0,
            ],
            [
                'name' => 'Quinoa',
                'category' => 'grain',
                'image_path' => 'images/recipe-game/ingredients/quinoa.png',
                'calories_per_serving' => 222,
                'protein_grams' => 8.1,
                'carbs_grams' => 39.0,
                'fat_grams' => 3.6,
                'fiber_grams' => 5.2,
                'sugar_grams' => 1.6,
                'sodium_mg' => 13.0,
            ],
            [
                'name' => 'Whole Wheat Pasta',
                'category' => 'grain',
                'image_path' => 'images/recipe-game/ingredients/whole-wheat-pasta.png',
                'calories_per_serving' => 174,
                'protein_grams' => 7.5,
                'carbs_grams' => 37.0,
                'fat_grams' => 0.8,
                'fiber_grams' => 6.3,
                'sugar_grams' => 0.5,
                'sodium_mg' => 4.0,
            ],
            [
                'name' => 'Oats',
                'category' => 'grain',
                'image_path' => 'images/recipe-game/ingredients/oats.png',
                'calories_per_serving' => 158,
                'protein_grams' => 6.0,
                'carbs_grams' => 27.0,
                'fat_grams' => 3.0,
                'fiber_grams' => 4.0,
                'sugar_grams' => 0.8,
                'sodium_mg' => 2.0,
            ],
            [
                'name' => 'Bread',
                'category' => 'grain',
                'image_path' => 'images/recipe-game/ingredients/bread.png',
                'calories_per_serving' => 79,
                'protein_grams' => 3.1,
                'carbs_grams' => 14.0,
                'fat_grams' => 1.1,
                'fiber_grams' => 1.9,
                'sugar_grams' => 1.4,
                'sodium_mg' => 152.0,
            ],
        ];

        // Dairy
        $dairy = [
            [
                'name' => 'Milk',
                'category' => 'dairy',
                'image_path' => 'images/recipe-game/ingredients/milk.png',
                'calories_per_serving' => 122,
                'protein_grams' => 8.1,
                'carbs_grams' => 12.0,
                'fat_grams' => 4.8,
                'fiber_grams' => 0.0,
                'sugar_grams' => 12.0,
                'sodium_mg' => 115.0,
            ],
            [
                'name' => 'Cheese',
                'category' => 'dairy',
                'image_path' => 'images/recipe-game/ingredients/cheese.png',
                'calories_per_serving' => 113,
                'protein_grams' => 7.0,
                'carbs_grams' => 0.4,
                'fat_grams' => 9.0,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.1,
                'sodium_mg' => 174.0,
            ],
            [
                'name' => 'Yogurt',
                'category' => 'dairy',
                'image_path' => 'images/recipe-game/ingredients/yogurt.png',
                'calories_per_serving' => 150,
                'protein_grams' => 8.5,
                'carbs_grams' => 17.0,
                'fat_grams' => 3.8,
                'fiber_grams' => 0.0,
                'sugar_grams' => 11.0,
                'sodium_mg' => 105.0,
            ],
        ];

        // Fruits
        $fruits = [
            [
                'name' => 'Apples',
                'category' => 'fruit',
                'image_path' => 'images/recipe-game/ingredients/apples.png',
                'calories_per_serving' => 95,
                'protein_grams' => 0.5,
                'carbs_grams' => 25.0,
                'fat_grams' => 0.3,
                'fiber_grams' => 4.4,
                'sugar_grams' => 19.0,
                'sodium_mg' => 2.0,
            ],
            [
                'name' => 'Bananas',
                'category' => 'fruit',
                'image_path' => 'images/recipe-game/ingredients/bananas.png',
                'calories_per_serving' => 105,
                'protein_grams' => 1.3,
                'carbs_grams' => 27.0,
                'fat_grams' => 0.4,
                'fiber_grams' => 3.1,
                'sugar_grams' => 14.0,
                'sodium_mg' => 1.0,
            ],
            [
                'name' => 'Berries',
                'category' => 'fruit',
                'image_path' => 'images/recipe-game/ingredients/berries.png',
                'calories_per_serving' => 85,
                'protein_grams' => 1.1,
                'carbs_grams' => 21.0,
                'fat_grams' => 0.5,
                'fiber_grams' => 7.0,
                'sugar_grams' => 12.0,
                'sodium_mg' => 1.0,
            ],
            [
                'name' => 'Oranges',
                'category' => 'fruit',
                'image_path' => 'images/recipe-game/ingredients/oranges.png',
                'calories_per_serving' => 62,
                'protein_grams' => 1.2,
                'carbs_grams' => 15.0,
                'fat_grams' => 0.2,
                'fiber_grams' => 3.1,
                'sugar_grams' => 12.0,
                'sodium_mg' => 0.0,
            ],
        ];

        // Fats
        $fats = [
            [
                'name' => 'Olive Oil',
                'category' => 'fat',
                'image_path' => 'images/recipe-game/ingredients/olive-oil.png',
                'calories_per_serving' => 119,
                'protein_grams' => 0.0,
                'carbs_grams' => 0.0,
                'fat_grams' => 14.0,
                'fiber_grams' => 0.0,
                'sugar_grams' => 0.0,
                'sodium_mg' => 0.0,
            ],
            [
                'name' => 'Avocado',
                'category' => 'fat',
                'image_path' => 'images/recipe-game/ingredients/avocado.png',
                'calories_per_serving' => 160,
                'protein_grams' => 2.0,
                'carbs_grams' => 8.5,
                'fat_grams' => 14.7,
                'fiber_grams' => 6.7,
                'sugar_grams' => 0.7,
                'sodium_mg' => 7.0,
            ],
            [
                'name' => 'Nuts',
                'category' => 'fat',
                'image_path' => 'images/recipe-game/ingredients/nuts.png',
                'calories_per_serving' => 170,
                'protein_grams' => 5.0,
                'carbs_grams' => 7.0,
                'fat_grams' => 15.0,
                'fiber_grams' => 3.0,
                'sugar_grams' => 1.5,
                'sodium_mg' => 0.0,
            ],
        ];

        // Combine all ingredients
        $allIngredients = array_merge($proteins, $vegetables, $grains, $dairy, $fruits, $fats);

        // Insert all ingredients
        foreach ($allIngredients as $ingredient) {
            RecipeIngredient::updateOrCreate(
                ['name' => $ingredient['name']],
                $ingredient
            );
        }

        $this->command->info('Recipe ingredients seeded successfully!');
    }
}
