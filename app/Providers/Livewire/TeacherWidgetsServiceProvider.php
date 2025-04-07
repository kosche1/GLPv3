<?php

namespace App\Providers\Livewire;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Filament\Teacher\Widgets\StudentStats;
use App\Livewire\Filament\Teacher\Widgets\RecentActivities;
use App\Livewire\Filament\Teacher\Widgets\UpcomingTasks;
use App\Livewire\Filament\Teacher\Widgets\TopStudents;
use App\Livewire\Filament\Teacher\Widgets\ChallengeCompletion;
use App\Livewire\Filament\Teacher\Resources\ChallengeResource\ListChallenges;
use App\Filament\Teacher\Resources\StudentAnswerResource\ListStudentAnswers;
use App\Filament\Teacher\Resources\UserResource\ListStudents;

class TeacherWidgetsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register widget components
        Livewire::component('filament.teacher.widgets.student-stats', StudentStats::class);
        Livewire::component('filament.teacher.widgets.recent-activities', RecentActivities::class);
        Livewire::component('filament.teacher.widgets.upcoming-tasks', UpcomingTasks::class);
        Livewire::component('filament.teacher.widgets.top-students', TopStudents::class);
        Livewire::component('filament.teacher.widgets.challenge-completion', ChallengeCompletion::class);

        // Register resource components
        Livewire::component('filament.teacher.resources.challenge-resource.list-challenges', ListChallenges::class);
        Livewire::component('filament.teacher.resources.student-answer-resource.list-student-answers', ListStudentAnswers::class);
        Livewire::component('filament.teacher.resources.user-resource.list-students', ListStudents::class);
    }
}
