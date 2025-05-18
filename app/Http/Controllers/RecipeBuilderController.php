<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngredient;
use App\Models\RecipeTemplate;
use App\Models\UserRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RecipeBuilderController extends Controller
{
    /**
     * Display the recipe builder game.
     */
    public function index(): View
    {
        // Get all ingredients grouped by category
        $ingredients = RecipeIngredient::orderBy('name')->get()->groupBy('category');

        // Get all recipe templates (challenges)
        $templates = RecipeTemplate::orderBy('difficulty_level')->orderBy('name')->get();

        // Get user's recent recipes
        $userRecipes = UserRecipe::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('recipe-builder.index', [
            'ingredients' => $ingredients,
            'templates' => $templates,
            'userRecipes' => $userRecipes,
        ]);
    }

    /**
     * Get all ingredients.
     */
    public function getIngredients()
    {
        $ingredients = RecipeIngredient::orderBy('name')->get();
        return response()->json($ingredients);
    }

    /**
     * Get a specific recipe template.
     */
    public function getTemplate($id)
    {
        $template = RecipeTemplate::findOrFail($id);
        return response()->json($template);
    }

    /**
     * Get all recipe templates (challenges).
     */
    public function getTemplates()
    {
        $templates = RecipeTemplate::orderBy('difficulty_level')->orderBy('name')->get();
        return response()->json($templates);
    }

    /**
     * Save a user recipe.
     */
    public function saveRecipe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_id' => 'nullable|exists:recipe_templates,id',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:recipe_ingredients,id',
            'ingredients.*.quantity' => 'required|integer|min:1',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the user recipe
            $userRecipe = new UserRecipe();
            $userRecipe->user_id = Auth::id();
            $userRecipe->recipe_template_id = $request->template_id;
            $userRecipe->name = $request->name;
            $userRecipe->description = $request->description;

            // Initialize nutritional values
            $userRecipe->total_calories = 0;
            $userRecipe->total_protein = 0;
            $userRecipe->total_carbs = 0;
            $userRecipe->total_fat = 0;

            $userRecipe->save();

            // Add ingredients to the recipe
            foreach ($request->ingredients as $ingredientData) {
                $ingredient = RecipeIngredient::find($ingredientData['id']);
                $quantity = $ingredientData['quantity'];

                $userRecipe->ingredients()->attach($ingredient->id, ['quantity' => $quantity]);
            }

            // Calculate nutrition, check requirements, and calculate score
            $userRecipe->calculateNutrition()
                ->checkRequirements()
                ->checkBalance()
                ->calculateScore()
                ->save();

            // Points will be awarded later by teacher/admin approval
            // Store the potential points to award in the recipe metadata
            $pointsToAward = $userRecipe->recipeTemplate ? $userRecipe->recipeTemplate->points_reward : 50;
            $userRecipe->potential_points = $pointsToAward;
            $userRecipe->points_awarded = false;
            $userRecipe->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'recipe' => $userRecipe->load('ingredients'),
                'message' => 'Recipe saved successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving recipe: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a user's recipe.
     */
    public function getUserRecipe($id)
    {
        $recipe = UserRecipe::with('ingredients')->findOrFail($id);

        // Check if the recipe belongs to the authenticated user
        if ($recipe->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($recipe);
    }

    /**
     * Get a user's recipes.
     */
    public function getUserRecipes()
    {
        $recipes = UserRecipe::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($recipes);
    }

    /**
     * Delete a user's recipe.
     */
    public function deleteRecipe($id)
    {
        $recipe = UserRecipe::findOrFail($id);

        // Check if the recipe belongs to the authenticated user
        if ($recipe->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $recipe->delete();

        return response()->json(['success' => true, 'message' => 'Recipe deleted successfully']);
    }
}
