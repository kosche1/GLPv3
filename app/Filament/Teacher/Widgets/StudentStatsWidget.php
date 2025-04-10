<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\User;
use App\Models\StudentAnswer;
use App\Models\StudentAttendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalStudents = User::role('student')->count();
        $activeToday = StudentAttendance::whereDate('date', today())->count();
        $completedTasks = StudentAnswer::where('is_correct', true)->count();
        $avgScore = number_format(StudentAnswer::where('is_correct', true)->avg('score') ?? 0, 1);

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('Registered in the system')
                ->descriptionIcon('heroicon-s-users')
                ->color('primary'),

            Stat::make('Active Today', $activeToday)
                ->description('Students present today')
                ->descriptionIcon('heroicon-s-user-group')
                ->color('success'),

            Stat::make('Completed Tasks', $completedTasks)
                ->description('Successfully completed tasks')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('warning'),

            Stat::make('Avg. Score', $avgScore)
                ->description('Average score for correct submissions')
                ->descriptionIcon('heroicon-s-academic-cap')
                ->color('danger'),
        ];
    }
}
