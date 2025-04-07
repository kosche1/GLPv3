<?php

namespace App\Livewire\Filament\Teacher\Widgets;

use App\Models\Activity;
use Livewire\Component;

class RecentActivities extends Component
{
    public function render()
    {
        $activities = Activity::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.filament.teacher.widgets.recent-activities', [
            'activities' => $activities,
        ]);
    }
}
