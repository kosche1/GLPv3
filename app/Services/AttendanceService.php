<?php

namespace App\Services;

use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AttendanceService
{
    protected $attendanceData = [];
    protected $tableExists = false;
    protected $loaded = false;

    public function __construct()
    {
        $this->tableExists = Schema::hasTable('student_attendance');
    }

    public function loadAttendanceData()
    {
        if ($this->loaded) {
            return;
        }

        if (!$this->tableExists) {
            Log::warning('AttendanceService: student_attendance table does not exist');
            $this->loaded = true;
            return;
        }

        try {
            // Get all student IDs
            $studentIds = User::role('student')->pluck('id')->toArray();

            if (empty($studentIds)) {
                $this->loaded = true;
                return;
            }

            // Log the student IDs for debugging
            Log::info('AttendanceService: Loading data for student IDs: ' . implode(', ', $studentIds));

            // Get total login days for all students
            $totalLogins = DB::table('student_attendance')
                ->select('user_id', DB::raw('COUNT(DISTINCT date) as total_days'))
                ->whereIn('user_id', $studentIds)
                ->where('status', 'present')
                ->groupBy('user_id')
                ->pluck('total_days', 'user_id')
                ->toArray();

            // Log the total logins for debugging
            Log::info('AttendanceService: Total logins: ' . json_encode($totalLogins));

            // Get last login date for all students
            $lastLogins = DB::table('student_attendance')
                ->select('user_id', DB::raw('MAX(date) as last_login_date'))
                ->whereIn('user_id', $studentIds)
                ->groupBy('user_id')
                ->pluck('last_login_date', 'user_id')
                ->toArray();

            // Log the last logins for debugging
            Log::info('AttendanceService: Last logins: ' . json_encode($lastLogins));

            // Initialize attendance data for all students, even those without records
            foreach ($studentIds as $studentId) {
                $this->attendanceData[$studentId] = [
                    'total_logins' => $totalLogins[$studentId] ?? 0,
                    'last_login' => $lastLogins[$studentId] ?? null,
                    'current_streak' => null,
                    'attendance_percentage' => null,
                ];
            }

            // Log the attendance data for debugging
            Log::info('AttendanceService: Attendance data loaded for ' . count($this->attendanceData) . ' students');

            $this->loaded = true;
        } catch (\Exception $e) {
            Log::error('Error loading attendance data: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function getTotalLogins($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }

        $this->loadAttendanceData();

        // First try to get from cached data
        if (isset($this->attendanceData[$userId]['total_logins'])) {
            return $this->attendanceData[$userId]['total_logins'];
        }

        // If not in cache, query directly
        $count = DB::table('student_attendance')
            ->where('user_id', $userId)
            ->where('status', 'present')
            ->distinct('date')
            ->count('date');

        // Cache the result
        $this->attendanceData[$userId]['total_logins'] = $count;

        return $count;
    }

    public function getCurrentStreak($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }

        $this->loadAttendanceData();

        // First try to get from cached data
        if (isset($this->attendanceData[$userId]['current_streak'])) {
            return $this->attendanceData[$userId]['current_streak'];
        }

        // If not in cache, calculate directly
        $today = now()->toDateString();
        $streak = 0;

        // Check if the student logged in today
        $todayLogin = DB::table('student_attendance')
            ->where('user_id', $userId)
            ->where('date', $today)
            ->exists();

        if (!$todayLogin) {
            // Check if they logged in yesterday to continue the streak
            $yesterday = now()->subDay()->toDateString();
            $yesterdayLogin = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $yesterday)
                ->exists();

            if (!$yesterdayLogin) {
                $this->attendanceData[$userId]['current_streak'] = 0;
                return 0; // Streak broken
            }
        }

        // Count consecutive days backwards
        $checkDate = $todayLogin ? $today : now()->subDay()->toDateString();
        $streakActive = true;

        while ($streakActive) {
            $hasLogin = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $checkDate)
                ->exists();

            if ($hasLogin) {
                $streak++;
                $checkDate = date('Y-m-d', strtotime($checkDate . ' -1 day'));
            } else {
                $streakActive = false;
            }
        }

        // Cache the result
        $this->attendanceData[$userId]['current_streak'] = $streak;

        return $streak;
    }

    public function getAttendancePercentage($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }

        $this->loadAttendanceData();

        // First try to get from cached data
        if (isset($this->attendanceData[$userId]['attendance_percentage'])) {
            return $this->attendanceData[$userId]['attendance_percentage'];
        }

        // If not in cache, calculate directly
        // Get the user's join date
        $user = User::find($userId);
        if (!$user) {
            return 0;
        }

        // Calculate days since joining
        $joinDate = $user->created_at->startOfDay();
        $today = now()->startOfDay();
        $daysSinceJoining = $joinDate->diffInDays($today) + 1; // +1 to include today

        // Get the number of days the user was present
        $presentDays = DB::table('student_attendance')
            ->where('user_id', $userId)
            ->where('status', 'present')
            ->count();

        // Calculate percentage
        $percentage = $daysSinceJoining > 0 ? round(($presentDays / $daysSinceJoining) * 100, 2) : 0;

        // Cache the result
        $this->attendanceData[$userId]['attendance_percentage'] = $percentage;

        return $percentage;
    }

    public function getLastLogin($userId)
    {
        if (!$this->tableExists) {
            return null;
        }

        $this->loadAttendanceData();

        // First try to get from cached data
        if (isset($this->attendanceData[$userId]['last_login'])) {
            return $this->attendanceData[$userId]['last_login'];
        }

        // If not in cache, query directly
        $lastLogin = DB::table('student_attendance')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->first();

        $lastLoginDate = $lastLogin ? $lastLogin->date : null;

        // Cache the result
        $this->attendanceData[$userId]['last_login'] = $lastLoginDate;

        return $lastLoginDate;
    }

    public function tableExists()
    {
        return $this->tableExists;
    }
}
