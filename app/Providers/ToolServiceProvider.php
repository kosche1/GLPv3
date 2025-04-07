<?php

namespace App\Providers;

use App\Tools\LevelUpDataTool;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LevelUpDataTool::class, function ($app) {
            return new LevelUpDataTool();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Instantiate the tool to register it with Prism
        $this->app->make(LevelUpDataTool::class);
    }
}
