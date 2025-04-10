<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Challenge;
use Filament\Widgets\Widget;

class ChallengeCompletionCards extends Widget
{
    protected static ?int $sort = 5;
    protected static string $view = 'filament.teacher.widgets.challenge-completion-cards';

    protected int | string | array $columnSpan = 'full';

    public function getChallenges()
    {
        return Challenge::query()
            ->where('is_active', true)
            ->withCount(['users as total_participants'])
            ->withCount(['users as completed_count' => function ($query) {
                $query->where('user_challenges.status', 'completed');
            }])
            ->orderBy('completed_count', 'desc')
            ->limit(6)
            ->get();
    }
}
