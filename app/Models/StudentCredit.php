<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCredit extends Model
{
    protected $table = 'student_credits';
    
    protected $fillable = [
        'user_id',
        'credits_completed',
        'credits_required',
        'completion_percentage',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getCreditsInfo($userId)
    {
        return self::where('user_id', $userId)
            ->select('credits_completed', 'credits_required', 'completion_percentage')
            ->first();
    }

    public static function updateCompletionPercentage($userId)
    {
        $record = self::where('user_id', $userId)->first();
        
        if ($record) {
            $percentage = ($record->credits_completed / $record->credits_required) * 100;
            $record->update([
                'completion_percentage' => round($percentage, 2)
            ]);
        }

        return $record;
    }
}