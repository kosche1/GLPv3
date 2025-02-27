<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Stat::make("Total Users", \App\Models\User::count())
            //     ->description("Total number of registered users")
            //     ->descriptionIcon("heroicon-s-users")
            //     ->color("primary"),

            Stat::make(
                "New Users Today",
                \App\Models\User::whereDate("created_at", today())->count()
            )
                ->description("Users registered today")
                ->descriptionIcon("heroicon-s-user")
                ->color("success"),

            Stat::make(
                "Active Users",
                \App\Models\User::whereNotNull("email_verified_at")->count()
            )
                ->description("Users with verified email")
                ->descriptionIcon("heroicon-s-check-circle")
                ->color("info"),

            // Stat::make(
            //     "Average Level",
            //     number_format(
            //         \App\Models\User::with("experience.level")->avg(
            //             "experience.level.level"
            //         ) ?? 0,
            //         1
            //     )
            // )
            //     ->description("Average user level")
            //     ->descriptionIcon("heroicon-s-chart-bar")
            //     ->color("warning"),
        ];
    }
}
