<?php

namespace App\Livewire\Filament\Teacher\Resources\ChallengeResource;

use App\Models\Challenge;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ListChallenges extends Component
{
    public function render(): View
    {
        $challenges = Challenge::query()
            ->with('tasks')
            ->latest()
            ->get();

        // Identify expired challenges using the model accessor
        $expiredChallengeIds = $challenges
            ->filter(function ($challenge) {
                return $challenge->isExpired();
            })
            ->pluck('id')
            ->toArray();

        return view('livewire.filament.teacher.resources.challenge-resource.list-challenges', [
            'challenges' => $challenges,
            'expiredChallengeIds' => $expiredChallengeIds,
        ]);
    }
}
