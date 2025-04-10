<x-filament-panels::page>
    <div>
        @livewire('\App\Filament\Teacher\Widgets\StudentStatsWidget')
    </div>

    <div class="mt-6">
        @livewire('\App\Filament\Teacher\Widgets\TopStudentsTable')
    </div>

    <div class="mt-6">
        @livewire('\App\Filament\Teacher\Widgets\ChallengeCompletionTable')
    </div>

    <div class="mt-6">
        @livewire('\App\Filament\Teacher\Widgets\StudentProgressTable')
    </div>
</x-filament-panels::page>
