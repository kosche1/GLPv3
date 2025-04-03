<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StudentAnswer;
use App\Observers\StudentAnswerObserver;

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
    }
}


