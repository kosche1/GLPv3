<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Noxo\FilamentActivityLog\FilamentActivityLogPlugin;

class FilamentActivityLogServiceProvider extends ServiceProvider
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
        // Register the Filament Activity Log plugin
        FilamentAsset::register([
            Css::make('filament-activity-log-styles', __DIR__ . '/../../vendor/noxoua/filament-activity-log/resources/dist/filament-activity-log.css'),
            Js::make('filament-activity-log-scripts', __DIR__ . '/../../vendor/noxoua/filament-activity-log/resources/dist/filament-activity-log.js'),
        ]);
    }
}
