<?php

namespace App\Filament\Widgets;

use App\Models\StudentAchievement;
use App\Models\StudentAttendance;
use App\Models\StudentCredit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        // Get Achievement Score
        $achievement = StudentAchievement::getLatestScore($userId);
        $score = $achievement ? $achievement->score : 0;
        $scoreChange = $achievement ? $achievement->score_change : 0;
        $scoreChangeColor = $scoreChange >= 0 ? 'success' : 'danger';

        // Get Attendance Percentage
        $attendancePercentage = StudentAttendance::getAttendancePercentage($userId);
        $attendanceChange = StudentAttendance::getAttendanceChange($userId);
        $attendanceChangeColor = $attendanceChange >= 0 ? 'success' : 'danger';

        // Get Credits Info
        $credits = StudentCredit::getCreditsInfo($userId);
        $creditsCompleted = $credits ? $credits->credits_completed : 0;
        $creditsRequired = $credits ? $credits->credits_required : 120;
        $completionPercentage = $credits ? $credits->completion_percentage : 0;

        return [
            Stat::make('Achievements', number_format($score, 2))
                ->description($scoreChange >= 0 ? "+{$scoreChange}" : $scoreChange)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($scoreChangeColor),

            Stat::make('Attendance', "{$attendancePercentage}%")
                ->description($attendanceChange >= 0 ? "+{$attendanceChange}%" : "{$attendanceChange}%")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($attendanceChangeColor),

            Stat::make('Credits Completed', "{$creditsCompleted}/{$creditsRequired}")
                ->description("{$completionPercentage}% completed")
                ->color('gray'),
        ];
    }
}