<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Here's an overview of your teaching dashboard.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6">
        @livewire('\App\Filament\Teacher\Widgets\TeacherDashboardWidget')
    </div>

    <div class="mt-6">
        @livewire('\App\Filament\Teacher\Widgets\TopStudentsTable')
    </div>

</x-filament-panels::page>
