<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use App\Filament\Components\CustomBackupDestinationListRecords;

class BackupServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Override the original component with our custom one
        Livewire::component('backup-destination-list-records', CustomBackupDestinationListRecords::class);
    }
}
