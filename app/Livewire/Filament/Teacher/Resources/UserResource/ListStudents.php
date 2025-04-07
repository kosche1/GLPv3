<?php

namespace App\Livewire\Filament\Teacher\Resources\UserResource;

use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ListStudents extends Component
{
    public function render(): View
    {
        $students = User::query()
            ->role('student')
            ->with('experience')
            ->withCount(['studentAnswers' => function ($query) {
                $query->where('is_correct', true);
            }])
            ->get();
            
        return view('livewire.filament.teacher.resources.user-resource.list-students', [
            'students' => $students,
        ]);
    }
}
