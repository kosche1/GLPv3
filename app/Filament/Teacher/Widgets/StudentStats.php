<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use App\Models\StudentAnswer;
use App\Models\StudentAttendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalStudents = User::role('student')->count();
        $activeStudents = StudentAttendance::whereDate('date', today())->distinct('user_id')->count('user_id');
        $completedTasks = StudentAnswer::where('is_correct', true)->count();

        // Calculate attendance percentage for the current month
        $startOfMonth = now()->startOfMonth()->toDateString();
        $currentDay = now()->day;

        $totalPossibleAttendance = $totalStudents * $currentDay; // Total possible attendance days so far this month
        $actualAttendance = StudentAttendance::whereBetween('date', [$startOfMonth, today()])->count();
        $attendanceRate = $totalPossibleAttendance > 0 ? round(($actualAttendance / $totalPossibleAttendance) * 100, 1) : 0;

        // Get students with perfect attendance this month
        $perfectAttendance = 0;
        $students = User::role('student')->get();
        foreach ($students as $student) {
            $loginDays = StudentAttendance::where('user_id', $student->id)
                ->whereBetween('date', [$startOfMonth, today()])
                ->count();
            if ($loginDays >= $currentDay) {
                $perfectAttendance++;
            }
        }

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('Total registered students')
                ->icon('heroicon-o-users'),

            Stat::make('Active Today', $activeStudents)
                ->description('Students active today')
                ->icon('heroicon-o-user-group'),

            Stat::make('Attendance Rate', $attendanceRate . '%')
                ->description('Monthly attendance rate')
                ->icon('heroicon-o-calendar'),

            Stat::make('Perfect Attendance', $perfectAttendance)
                ->description('Students with perfect attendance')
                ->icon('heroicon-o-star'),

            Stat::make('Completed Tasks', $completedTasks)
                ->description('Successfully completed tasks')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}