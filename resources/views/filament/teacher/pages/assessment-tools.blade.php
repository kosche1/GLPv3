<x-filament-panels::page>
    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Reviews</p>
                    <p class="text-2xl font-semibold">{{ \App\Models\StudentAnswer::where('status', 'pending_manual_evaluation')->count() }}</p>
                </div>
                <div class="rounded-full bg-warning-100 dark:bg-warning-900/20 p-2">
                    <x-heroicon-o-clock class="h-5 w-5 text-warning-600 dark:text-warning-400" />
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Evaluated Today</p>
                    <p class="text-2xl font-semibold">{{ \App\Models\StudentAnswer::whereDate('evaluated_at', today())->count() }}</p>
                </div>
                <div class="rounded-full bg-success-100 dark:bg-success-900/20 p-2">
                    <x-heroicon-o-check-circle class="h-5 w-5 text-success-600 dark:text-success-400" />
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Score</p>
                    <p class="text-2xl font-semibold">{{ number_format(\App\Models\StudentAnswer::where('is_correct', true)->avg('score') ?? 0, 1) }}</p>
                </div>
                <div class="rounded-full bg-primary-100 dark:bg-primary-900/20 p-2">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-primary-600 dark:text-primary-400" />
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament-panels::page>
