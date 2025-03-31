<x-filament-panels::page>
    <x-filament-widgets-grid>
        <x-filament::section>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-medium tracking-tight">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Here's an overview of your teaching dashboard.</p>
                </div>
            </div>
        </x-filament::section>

        @livewire('filament.teacher.widgets.student-stats')
        @livewire('filament.teacher.widgets.recent-activities')
        @livewire('filament.teacher.widgets.upcoming-tasks')
    </x-filament-widgets-grid>
</x-filament-panels::page>
