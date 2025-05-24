<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypingTestResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'challenge_id',
        'wpm',
        'cpm',
        'accuracy',
        'word_count',
        'test_mode',
        'time_limit',
        'test_duration',
        'words_typed',
        'characters_typed',
        'errors',
    ];

    /**
     * Get the user that owns the typing test result.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge that this result belongs to.
     */
    public function challenge()
    {
        return $this->belongsTo(TypingTestChallenge::class, 'challenge_id');
    }
}
