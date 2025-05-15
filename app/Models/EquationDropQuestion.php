<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquationDropQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'equation_drop_id',
        'difficulty',
        'display_elements',
        'answer',
        'hint',
        'options',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'display_elements' => 'array',
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the equation drop that owns the question.
     */
    public function equationDrop()
    {
        return $this->belongsTo(EquationDrop::class);
    }
}
