<?php

namespace App\Livewire\Filament\Teacher\Widgets;

use App\Models\Task;
use Livewire\Component;

class UpcomingTasks extends Component
{
    public function render()
    {
        $tasks = Task::query()
            ->with('challenge')
            ->whereDate('due_date', '>=', now())
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('livewire.filament.teacher.widgets.upcoming-tasks', [
            'tasks' => $tasks,
        ]);
    }
}
