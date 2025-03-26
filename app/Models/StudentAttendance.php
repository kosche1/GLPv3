<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    protected $table = 'student_attendance';
    
    protected $fillable = [
        'user_id',
        'date',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getAttendancePercentage($userId)
    {
        $total = self::where('user_id', $userId)->count();
        $present = self::where('user_id', $userId)
            ->where('status', 'present')
            ->count();

        return $total > 0 ? round(($present / $total) * 100, 2) : 0;
    }

    public static function getAttendanceChange($userId)
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;

        $currentPercentage = self::getMonthlyAttendancePercentage($userId, $currentMonth);
        $lastPercentage = self::getMonthlyAttendancePercentage($userId, $lastMonth);

        return round($currentPercentage - $lastPercentage, 2);
    }

    private static function getMonthlyAttendancePercentage($userId, $month)
    {
        $total = self::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->count();

        $present = self::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->where('status', 'present')
            ->count();

        return $total > 0 ? round(($present / $total) * 100, 2) : 0;
    }
}