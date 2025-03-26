<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAchievement extends Model
{
    protected $table = 'student_achievements';
    
    protected $fillable = [
        'user_id',
        'score',
        'score_change',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getLatestScore($userId)
    {
        return self::where('user_id', $userId)
            ->latest()
            ->first();
    }
}