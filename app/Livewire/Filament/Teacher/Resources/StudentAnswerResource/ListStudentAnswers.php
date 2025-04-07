<?php

namespace App\Livewire\Filament\Teacher\Resources\StudentAnswerResource;

use App\Models\StudentAnswer;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ListStudentAnswers extends Component
{
    public function render(): View
    {
        $studentAnswers = StudentAnswer::query()
            ->with(['user', 'task'])
            ->latest()
            ->get();
            
        return view('livewire.filament.teacher.resources.student-answer-resource.list-student-answers', [
            'studentAnswers' => $studentAnswers,
        ]);
    }
}
