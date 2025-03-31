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
        $activeStudents = StudentAttendance::whereDate('created_at', today())->count();
        $completedTasks = StudentAnswer::where('is_correct', true)->count();

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('Total registered students')
                ->icon('heroicon-o-users'),

            Stat::make('Active Today', $activeStudents)
                ->description('Students active today')
                ->icon('heroicon-o-user-group'),

            Stat::make('Completed Tasks', $completedTasks)
                ->description('Successfully completed tasks')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}