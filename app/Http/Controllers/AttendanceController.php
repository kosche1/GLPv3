<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display attendance information for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function myAttendance()
    {
        $userId = Auth::id();
        $user = Auth::user();

        // Get attendance data
        $attendanceHistory = StudentAttendance::getAttendanceHistory($userId);
        $totalLoginDays = StudentAttendance::getTotalLoginDays($userId);
        $currentStreak = StudentAttendance::getCurrentLoginStreak($userId);
        $attendancePercentage = StudentAttendance::getAttendancePercentage($userId);

        // Get attendance for the current month
        $currentMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        $currentMonthLogins = StudentAttendance::getTotalLoginDays($userId, $currentMonth, $endOfMonth);
        $daysInMonth = now()->daysInMonth;
        $monthlyPercentage = $daysInMonth > 0 ? round(($currentMonthLogins / $daysInMonth) * 100, 1) : 0;

        // Get attendance for the current week
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();
        $currentWeekLogins = StudentAttendance::getTotalLoginDays($userId, $startOfWeek, $endOfWeek);
        $daysInWeek = 7;
        $weeklyPercentage = round(($currentWeekLogins / $daysInWeek) * 100, 1);

        // Get the last 7 days of attendance for the chart
        $last7Days = [];
        $last7DaysLabels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $last7DaysLabels[] = now()->subDays($i)->format('D');

            $attended = StudentAttendance::where('user_id', $userId)
                ->where('date', $date)
                ->exists();

            $last7Days[] = $attended ? 1 : 0;
        }

        return view('attendance.my-attendance', compact(
            'user',
            'attendanceHistory',
            'totalLoginDays',
            'currentStreak',
            'attendancePercentage',
            'currentMonthLogins',
            'daysInMonth',
            'monthlyPercentage',
            'currentWeekLogins',
            'weeklyPercentage',
            'last7Days',
            'last7DaysLabels'
        ));
    }

    /**
     * Display attendance information for all students (teacher/admin view)
     *
     * @return \Illuminate\Http\Response
     */
    public function allStudents()
    {
        // Check if user has permission to view all students
        if (!Auth::user()->hasRole(['admin', 'teacher'])) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        // Get all students
        $students = User::role('student')->get();

        // Get attendance data for each student
        $studentsData = [];
        foreach ($students as $student) {
            $studentsData[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'total_logins' => StudentAttendance::getTotalLoginDays($student->id),
                'current_streak' => StudentAttendance::getCurrentLoginStreak($student->id),
                'attendance_percentage' => StudentAttendance::getAttendancePercentage($student->id),
                'last_login' => StudentAttendance::getAttendanceHistory($student->id, null, null)
                    ->first()?->date ?? 'Never'
            ];
        }

        return view('attendance.all-students', compact('studentsData'));
    }

    /**
     * Display detailed attendance information for a specific student
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function studentDetail($id)
    {
        // Check if user has permission to view student details
        if (!Auth::user()->hasRole(['admin', 'teacher']) && Auth::id() != $id) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        $student = User::findOrFail($id);
        $attendanceHistory = StudentAttendance::getAttendanceHistory($id);
        $totalLoginDays = StudentAttendance::getTotalLoginDays($id);
        $currentStreak = StudentAttendance::getCurrentLoginStreak($id);
        $attendancePercentage = StudentAttendance::getAttendancePercentage($id);

        return view('attendance.student-detail', compact(
            'student',
            'attendanceHistory',
            'totalLoginDays',
            'currentStreak',
            'attendancePercentage'
        ));
    }
}
