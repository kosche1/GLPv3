<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Badge;
use App\Models\Achievement;
use App\Models\Task;
use App\Models\Referral;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class DashboardWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $totalUsers = User::count();
        $totalPoints = User::join(
            "experiences",
            "users.id",
            "=",
            "experiences.user_id"
        )->sum("experiences.experience_points");

        $totalAchievements = 0;
        if (class_exists("\LevelUp\Experience\Models\Achievement")) {
            $totalAchievements = \LevelUp\Experience\Models\Achievement::count();
        }

        $badgesAwarded = 0;
        if (class_exists("App\Models\UserBadge")) {
            $badgesAwarded = \App\Models\UserBadge::count();
        }

        $activeTasks = 0;
        if (class_exists("App\Models\Task")) {
            $activeTasks = \App\Models\Task::where("is_active", true)->count();
        }

        $successfulReferrals = 0;
        if (class_exists("App\Models\Referral")) {
            $successfulReferrals = \App\Models\Referral::where(
                "status",
                "rewarded"
            )->count();
        }

        return [
            Card::make("Total Users", $totalUsers)
                ->description("Participating in gamification")
                ->descriptionIcon("heroicon-s-users"),

            Card::make("Total XP Points", number_format($totalPoints))
                ->description("Accumulated by all users")
                ->descriptionIcon("heroicon-s-chart-bar"),

            Card::make("Achievements Created", $totalAchievements)
                ->description("Available to be earned")
                ->descriptionIcon("heroicon-o-check-badge"),

            Card::make("Badges Awarded", $badgesAwarded)
                ->description("Total badges earned by users")
                ->descriptionIcon("heroicon-s-shield-check"),

            Card::make("Active Tasks", $activeTasks)
                ->description("Tasks available for completion")
                ->descriptionIcon("heroicon-o-clipboard"),

            Card::make("Successful Referrals", $successfulReferrals)
                ->description("Completed and rewarded")
                ->descriptionIcon("heroicon-s-user-plus"),
        ];
    }
}
