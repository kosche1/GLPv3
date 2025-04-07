<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Student Analytics</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Track student performance and progress metrics.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Performance Overview</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Key metrics for student performance.</p>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                                <p class="text-2xl font-semibold">{{ \App\Models\User::role('student')->count() }}</p>
                            </div>
                            <div class="rounded-full bg-primary-100 dark:bg-primary-900/20 p-2">
                                <x-heroicon-o-users class="h-5 w-5 text-primary-600 dark:text-primary-400" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Today</p>
                                <p class="text-2xl font-semibold">{{ \App\Models\StudentAttendance::whereDate('created_at', today())->count() }}</p>
                            </div>
                            <div class="rounded-full bg-success-100 dark:bg-success-900/20 p-2">
                                <x-heroicon-o-user-group class="h-5 w-5 text-success-600 dark:text-success-400" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Tasks</p>
                                <p class="text-2xl font-semibold">{{ \App\Models\StudentAnswer::where('is_correct', true)->count() }}</p>
                            </div>
                            <div class="rounded-full bg-warning-100 dark:bg-warning-900/20 p-2">
                                <x-heroicon-o-check-circle class="h-5 w-5 text-warning-600 dark:text-warning-400" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Score</p>
                                <p class="text-2xl font-semibold">{{ number_format(\App\Models\StudentAnswer::where('is_correct', true)->avg('score') ?? 0, 1) }}</p>
                            </div>
                            <div class="rounded-full bg-danger-100 dark:bg-danger-900/20 p-2">
                                <x-heroicon-o-academic-cap class="h-5 w-5 text-danger-600 dark:text-danger-400" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Top Performing Students</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Students with the highest achievement scores.</p>

                <div class="mt-4">
                    @livewire('\App\Filament\Teacher\Widgets\TopStudentsTable')
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Challenge Completion Rates</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Completion rates for active challenges.</p>

                <div class="mt-4">
                    @livewire('\App\Filament\Teacher\Widgets\ChallengeCompletionTable')
                </div>
            </div>
        </x-filament::section>
    </div>

    <div class="mt-6">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Student Progress</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Detailed view of individual student progress.</p>

                <div class="mt-4">
                    @livewire('\App\Filament\Teacher\Widgets\StudentProgressTable')
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
