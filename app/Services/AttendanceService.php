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
            
            // Get total login days for all students
            $totalLogins = DB::table('student_attendance')
                ->select('user_id', DB::raw('COUNT(DISTINCT date) as total_days'))
                ->whereIn('user_id', $studentIds)
                ->where('status', 'present')
                ->groupBy('user_id')
                ->pluck('total_days', 'user_id')
                ->toArray();
            
            // Get last login date for all students
            $lastLogins = DB::table('student_attendance')
                ->select('user_id', DB::raw('MAX(date) as last_login_date'))
                ->whereIn('user_id', $studentIds)
                ->groupBy('user_id')
                ->pluck('last_login_date', 'user_id')
                ->toArray();
            
            // Store the data for use in the table
            foreach ($studentIds as $studentId) {
                $this->attendanceData[$studentId] = [
                    'total_logins' => $totalLogins[$studentId] ?? 0,
                    'last_login' => $lastLogins[$studentId] ?? null,
                    // We'll calculate these on-demand as they're more complex
                    'current_streak' => null,
                    'attendance_percentage' => null,
                ];
            }
            
            $this->loaded = true;
        } catch (\Exception $e) {
            Log::error('Error loading attendance data: ' . $e->getMessage());
        }
    }

    public function getTotalLogins($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }
        
        $this->loadAttendanceData();
        
        return $this->attendanceData[$userId]['total_logins'] ?? 
               StudentAttendance::getTotalLoginDays($userId);
    }

    public function getCurrentStreak($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }
        
        $this->loadAttendanceData();
        
        if (!isset($this->attendanceData[$userId]['current_streak'])) {
            $this->attendanceData[$userId]['current_streak'] = 
                StudentAttendance::getCurrentLoginStreak($userId);
        }
        
        return $this->attendanceData[$userId]['current_streak'];
    }

    public function getAttendancePercentage($userId)
    {
        if (!$this->tableExists) {
            return 0;
        }
        
        $this->loadAttendanceData();
        
        if (!isset($this->attendanceData[$userId]['attendance_percentage'])) {
            $this->attendanceData[$userId]['attendance_percentage'] = 
                StudentAttendance::getAttendancePercentage($userId);
        }
        
        return $this->attendanceData[$userId]['attendance_percentage'];
    }

    public function getLastLogin($userId)
    {
        if (!$this->tableExists) {
            return null;
        }
        
        $this->loadAttendanceData();
        
        $lastLoginDate = $this->attendanceData[$userId]['last_login'] ?? null;
        
        if ($lastLoginDate) {
            return $lastLoginDate;
        } else {
            // Fallback to the original method if data isn't in our cache
            $lastLogin = StudentAttendance::getAttendanceHistory($userId, null, null)->first();
            return $lastLogin ? $lastLogin->date->format('Y-m-d') : null;
        }
    }

    public function tableExists()
    {
        return $this->tableExists;
    }
}
