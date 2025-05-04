<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRecipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_template_id',
        'name',
        'description',
        'total_calories',
        'total_protein',
        'total_carbs',
        'total_fat',
        'is_balanced',
        'meets_requirements',
        'score',
        'potential_points',
        'points_awarded',
        'notification_shown',
        'points_awarded_at',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_balanced' => 'boolean',
        'meets_requirements' => 'boolean',
        'points_awarded' => 'boolean',
        'notification_shown' => 'boolean',
        'points_awarded_at' => 'datetime',
    ];

    /**
     * Get the user that owns the recipe.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template that this recipe is based on.
     */
    public function recipeTemplate(): BelongsTo
    {
        return $this->belongsTo(RecipeTemplate::class);
    }

    /**
     * Get the user who approved this recipe.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the ingredients for this recipe.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(RecipeIngredient::class, 'user_recipe_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Calculate nutritional totals based on ingredients
     */
    public function calculateNutrition()
    {
        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        foreach ($this->ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity;
            $totalCalories += $ingredient->calories_per_serving * $quantity;
            $totalProtein += $ingredient->protein_grams * $quantity;
            $totalCarbs += $ingredient->carbs_grams * $quantity;
            $totalFat += $ingredient->fat_grams * $quantity;
        }

        $this->total_calories = $totalCalories;
        $this->total_protein = $totalProtein;
        $this->total_carbs = $totalCarbs;
        $this->total_fat = $totalFat;

        return $this;
    }

    /**
     * Check if the recipe meets the template requirements
     */
    public function checkRequirements()
    {
        if (!$this->recipe_template_id) {
            $this->meets_requirements = true;
            return $this;
        }

        $template = $this->recipeTemplate;
        $meetsRequirements = true;

        // Check calorie range
        if ($this->total_calories < $template->target_calories_min ||
            $this->total_calories > $template->target_calories_max) {
            $meetsRequirements = false;
        }

        // Check macronutrient ranges if specified
        if ($template->target_protein_min && $this->total_protein < $template->target_protein_min) {
            $meetsRequirements = false;
        }
        if ($template->target_protein_max && $this->total_protein > $template->target_protein_max) {
            $meetsRequirements = false;
        }
        if ($template->target_carbs_min && $this->total_carbs < $template->target_carbs_min) {
            $meetsRequirements = false;
        }
        if ($template->target_carbs_max && $this->total_carbs > $template->target_carbs_max) {
            $meetsRequirements = false;
        }
        if ($template->target_fat_min && $this->total_fat < $template->target_fat_min) {
            $meetsRequirements = false;
        }
        if ($template->target_fat_max && $this->total_fat > $template->target_fat_max) {
            $meetsRequirements = false;
        }

        // Check required categories
        if ($template->required_categories) {
            $ingredientCategories = $this->ingredients->pluck('category')->unique()->toArray();
            foreach ($template->required_categories as $requiredCategory) {
                if (!in_array($requiredCategory, $ingredientCategories)) {
                    $meetsRequirements = false;
                    break;
                }
            }
        }

        // Check required ingredients
        if ($template->required_ingredients) {
            $ingredientIds = $this->ingredients->pluck('id')->toArray();
            foreach ($template->required_ingredients as $requiredIngredientId) {
                if (!in_array($requiredIngredientId, $ingredientIds)) {
                    $meetsRequirements = false;
                    break;
                }
            }
        }

        // Check forbidden ingredients
        if ($template->forbidden_ingredients) {
            $ingredientIds = $this->ingredients->pluck('id')->toArray();
            foreach ($template->forbidden_ingredients as $forbiddenIngredientId) {
                if (in_array($forbiddenIngredientId, $ingredientIds)) {
                    $meetsRequirements = false;
                    break;
                }
            }
        }

        // Check max ingredients
        if (count($this->ingredients) > $template->max_ingredients) {
            $meetsRequirements = false;
        }

        $this->meets_requirements = $meetsRequirements;
        return $this;
    }

    /**
     * Check if the recipe is nutritionally balanced
     */
    public function checkBalance()
    {
        // Calculate macronutrient percentages
        $totalCaloriesFromMacros =
            ($this->total_protein * 4) +
            ($this->total_carbs * 4) +
            ($this->total_fat * 9);

        if ($totalCaloriesFromMacros == 0) {
            $this->is_balanced = false;
            return $this;
        }

        $proteinPercentage = ($this->total_protein * 4) / $totalCaloriesFromMacros * 100;
        $carbsPercentage = ($this->total_carbs * 4) / $totalCaloriesFromMacros * 100;
        $fatPercentage = ($this->total_fat * 9) / $totalCaloriesFromMacros * 100;

        // Check if macros are within healthy ranges
        // Protein: 10-35%, Carbs: 45-65%, Fat: 20-35%
        $isBalanced =
            $proteinPercentage >= 10 && $proteinPercentage <= 35 &&
            $carbsPercentage >= 45 && $carbsPercentage <= 65 &&
            $fatPercentage >= 20 && $fatPercentage <= 35;

        $this->is_balanced = $isBalanced;
        return $this;
    }

    /**
     * Calculate score based on nutritional balance and meeting requirements
     */
    public function calculateScore()
    {
        $score = 0;

        // Base score for creating a recipe
        $score += 50;

        // Bonus for balanced nutrition
        if ($this->is_balanced) {
            $score += 100;
        }

        // Bonus for meeting template requirements
        if ($this->meets_requirements) {
            $score += 150;
        }

        // Bonus for variety (using different food categories)
        $uniqueCategories = $this->ingredients->pluck('category')->unique()->count();
        $score += $uniqueCategories * 20;

        $this->score = $score;
        return $this;
    }
}
