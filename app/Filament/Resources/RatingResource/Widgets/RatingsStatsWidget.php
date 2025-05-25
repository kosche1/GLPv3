<?php

namespace App\Filament\Resources\RatingResource\Widgets;

use App\Models\Rating;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RatingsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRatings = Rating::count();
        $averageRating = Rating::avg('rating');
        $recentRatings = Rating::where('created_at', '>=', now()->subDays(30))->count();

        // Get rating distribution
        $ratingCounts = Rating::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $fiveStarCount = $ratingCounts[5] ?? 0;
        $fourStarCount = $ratingCounts[4] ?? 0;
        $positiveRatings = $fiveStarCount + $fourStarCount;
        $positivePercentage = $totalRatings > 0 ? round(($positiveRatings / $totalRatings) * 100, 1) : 0;

        return [
            Stat::make('Total Ratings', $totalRatings)
                ->description('All time ratings received')
                ->descriptionIcon('heroicon-m-star')
                ->color('primary'),

            Stat::make('Average Rating', $averageRating ? number_format($averageRating, 1) . '/5' : 'N/A')
                ->description('Overall satisfaction score')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($averageRating >= 4 ? 'success' : ($averageRating >= 3 ? 'warning' : 'danger')),

            Stat::make('Recent Ratings', $recentRatings)
                ->description('Last 30 days')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Positive Ratings', $positivePercentage . '%')
                ->description('4-5 star ratings')
                ->descriptionIcon('heroicon-m-hand-thumb-up')
                ->color($positivePercentage >= 80 ? 'success' : ($positivePercentage >= 60 ? 'warning' : 'danger')),
        ];
    }
}
