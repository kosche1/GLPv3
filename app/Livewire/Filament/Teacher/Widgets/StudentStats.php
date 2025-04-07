<?php

namespace App\Livewire\Filament\Teacher\Widgets;

use App\Models\User;
use App\Models\StudentAnswer;
use App\Models\StudentAttendance;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Component;

class StudentStats extends Component
{
    public function render()
    {
        $totalStudents = User::role('student')->count();
        $activeStudents = StudentAttendance::whereDate('created_at', today())->count();
        $completedTasks = StudentAnswer::where('is_correct', true)->count();

        $stats = [
            [
                'label' => 'Total Students',
                'value' => $totalStudents,
                'description' => 'Total registered students',
                'icon' => 'heroicon-o-users',
            ],
            [
                'label' => 'Active Today',
                'value' => $activeStudents,
                'description' => 'Students active today',
                'icon' => 'heroicon-o-user-group',
            ],
            [
                'label' => 'Completed Tasks',
                'value' => $completedTasks,
                'description' => 'Successfully completed tasks',
                'icon' => 'heroicon-o-check-circle',
            ],
        ];

        return view('livewire.filament.teacher.widgets.student-stats', [
            'stats' => $stats,
        ]);
    }
}
