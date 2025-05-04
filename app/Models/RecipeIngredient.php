<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecipeIngredient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'image_path',
        'calories_per_serving',
        'protein_grams',
        'carbs_grams',
        'fat_grams',
        'fiber_grams',
        'sugar_grams',
        'sodium_mg',
    ];

    /**
     * Get the user recipes that use this ingredient.
     */
    public function userRecipes(): BelongsToMany
    {
        return $this->belongsToMany(UserRecipe::class, 'user_recipe_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
