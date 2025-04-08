<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

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
        // Get the user's join date
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return 0;
        }

        // Calculate days since joining
        $joinDate = $user->created_at->startOfDay();
        $today = now()->startOfDay();
        $daysSinceJoining = $joinDate->diffInDays($today) + 1; // +1 to include today

        // Get the number of days the user was present
        $presentDays = self::where('user_id', $userId)
            ->where('status', 'present')
            ->count();

        // Calculate percentage
        return $daysSinceJoining > 0 ? round(($presentDays / $daysSinceJoining) * 100, 2) : 0;
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

    public static function recordDailyAttendance($userId)
    {
        try {
            Log::info('StudentAttendance::recordDailyAttendance called for user ' . $userId);

            $today = now()->toDateString();
            Log::info('Today is ' . $today);

            // Check if attendance already recorded for today
            $existingAttendance = self::where('user_id', $userId)
                ->where('date', $today)
                ->first();

            Log::info('Existing attendance check result', [
                'exists' => $existingAttendance ? 'yes' : 'no',
                'user_id' => $userId,
                'date' => $today
            ]);

            if (!$existingAttendance) {
                Log::info('Creating new attendance record for user ' . $userId);

                $newAttendance = self::create([
                    'user_id' => $userId,
                    'date' => $today,
                    'status' => 'present',
                    'notes' => 'Logged in at ' . now()->format('H:i:s')
                ]);

                Log::info('New attendance record created', [
                    'id' => $newAttendance->id,
                    'user_id' => $newAttendance->user_id,
                    'date' => $newAttendance->date
                ]);

                return $newAttendance;
            } else {
                Log::info('Updating existing attendance record', [
                    'id' => $existingAttendance->id,
                    'user_id' => $existingAttendance->user_id,
                    'date' => $existingAttendance->date
                ]);

                // Update the notes to indicate multiple logins if needed
                if (!str_contains($existingAttendance->notes, 'Additional login')) {
                    $existingAttendance->notes .= '. Additional login at ' . now()->format('H:i:s');
                    $existingAttendance->save();

                    Log::info('Updated attendance record notes');
                } else {
                    Log::info('No need to update attendance record notes');
                }
            }

            return $existingAttendance;
        } catch (\Exception $e) {
            Log::error('Error in StudentAttendance::recordDailyAttendance: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get student attendance history for a specific date range
     *
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAttendanceHistory($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Get the total number of days a student has logged in
     *
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public static function getTotalLoginDays($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->where('status', 'present');

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->distinct('date')->count('date');
    }

    /**
     * Get the current login streak (consecutive days) for a student
     *
     * @param int $userId
     * @return int
     */
    public static function getCurrentLoginStreak($userId)
    {
        $today = now()->toDateString();
        $streak = 0;

        // Check if the student logged in today
        $todayLogin = self::where('user_id', $userId)
            ->where('date', $today)
            ->exists();

        if (!$todayLogin) {
            // Check if they logged in yesterday to continue the streak
            $yesterday = now()->subDay()->toDateString();
            $yesterdayLogin = self::where('user_id', $userId)
                ->where('date', $yesterday)
                ->exists();

            if (!$yesterdayLogin) {
                return 0; // Streak broken
            }
        }

        // Count consecutive days backwards
        $checkDate = $todayLogin ? $today : now()->subDay()->toDateString();
        $streakActive = true;

        while ($streakActive) {
            $hasLogin = self::where('user_id', $userId)
                ->where('date', $checkDate)
                ->exists();

            if ($hasLogin) {
                $streak++;
                $checkDate = date('Y-m-d', strtotime($checkDate . ' -1 day'));
            } else {
                $streakActive = false;
            }
        }

        return $streak;
    }
}
