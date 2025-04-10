<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use App\Models\Task;
use App\Models\Challenge;
use App\Models\StudentAnswer;
use App\Models\StudentAttendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeacherDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalStudents = User::role('student')->count();

        $totalTasks = Task::count();
        $activeTasks = Task::where('is_active', true)->count();

        $totalChallenges = Challenge::count();
        $activeChallenges = Challenge::where('is_active', true)->count();

        $totalSubmissions = StudentAnswer::count();
        $correctSubmissions = StudentAnswer::where('is_correct', true)->count();
        $submissionRate = $totalSubmissions > 0 ? round(($correctSubmissions / $totalSubmissions) * 100, 1) : 0;

        // Calculate attendance for today
        $todayAttendance = StudentAttendance::whereDate('date', today())->distinct('user_id')->count('user_id');
        $attendanceRate = $totalStudents > 0 ? round(($todayAttendance / $totalStudents) * 100, 1) : 0;

        return [
            Stat::make('Active Tasks', $activeTasks)
                ->description("Out of {$totalTasks} total tasks")
                ->descriptionIcon('heroicon-s-clipboard-document-check')
                ->color('success'),

            Stat::make('Active Challenges', $activeChallenges)
                ->description("Out of {$totalChallenges} total challenges")
                ->descriptionIcon('heroicon-s-trophy')
                ->color('warning'),

            Stat::make('Submission Success Rate', $submissionRate . '%')
                ->description("{$correctSubmissions} correct out of {$totalSubmissions}")
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('info'),

            Stat::make('Today\'s Attendance', $attendanceRate . '%')
                ->description("{$todayAttendance} students present today")
                ->descriptionIcon('heroicon-s-calendar')
                ->color('danger'),

            Stat::make('Total Correct Submissions', $correctSubmissions)
                ->description('Successfully completed tasks')
                ->descriptionIcon('heroicon-s-academic-cap')
                ->color('gray'),
        ];
    }
}
