<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquationDrop extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equation_drops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the questions for the equation drop.
     */
    public function questions()
    {
        return $this->hasMany(EquationDropQuestion::class);
    }

    /**
     * Get easy difficulty questions.
     */
    public function easyQuestions()
    {
        return $this->questions()->where('difficulty', 'easy')->where('is_active', true)->orderBy('order');
    }

    /**
     * Get medium difficulty questions.
     */
    public function mediumQuestions()
    {
        return $this->questions()->where('difficulty', 'medium')->where('is_active', true)->orderBy('order');
    }

    /**
     * Get hard difficulty questions.
     */
    public function hardQuestions()
    {
        return $this->questions()->where('difficulty', 'hard')->where('is_active', true)->orderBy('order');
    }
}
