<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StudentAnswer;
use App\Observers\StudentAnswerObserver;
use Livewire\Livewire;
use App\Livewire\GradesComponent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        StudentAnswer::observe(StudentAnswerObserver::class);

        // Register Livewire components
        Livewire::component('grades-component', GradesComponent::class);
    }
}


