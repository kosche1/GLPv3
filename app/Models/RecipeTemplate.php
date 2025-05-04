<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecipeTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'difficulty_level',
        'target_calories_min',
        'target_calories_max',
        'target_protein_min',
        'target_carbs_min',
        'target_fat_min',
        'target_protein_max',
        'target_carbs_max',
        'target_fat_max',
        'required_categories',
        'required_ingredients',
        'forbidden_ingredients',
        'max_ingredients',
        'points_reward',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'required_categories' => 'array',
        'required_ingredients' => 'array',
        'forbidden_ingredients' => 'array',
    ];

    /**
     * Get the user recipes based on this template.
     */
    public function userRecipes(): HasMany
    {
        return $this->hasMany(UserRecipe::class);
    }
}
