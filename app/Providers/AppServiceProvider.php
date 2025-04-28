<?php

namespace App\Providers;

use Livewire\Livewire;
use Prism\Prism\Prism;
use App\Models\StudentAnswer;
use Prism\Prism\Enums\Provider;
use App\Livewire\GradesComponent;
use App\Livewire\SessionTimeout;
use Prism\Prism\Facades\PrismServer;
use Prism\Prism\Text\PendingRequest;
use Illuminate\Support\ServiceProvider;
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

        // Register Livewire components
        Livewire::component('grades-component', GradesComponent::class);
        Livewire::component('session-timeout', SessionTimeout::class);

        // Configure Prism providers
        $this->configurePrisms();
    }
    private function configurePrisms(): void
    {
        // This is example of how to register a Prism.
        PrismServer::register(
            'Gemini 2.0 Flash',
            fn (): PendingRequest => Prism::text()
                ->using(Provider::Gemini, 'gemini-2.0-flash')
                // ->withSystemPrompt(view('prompts.system')->render())
                ->withMaxTokens(1000)
        );


    }
}


