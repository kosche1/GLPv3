<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Assessment Tools</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Evaluate student submissions and provide feedback.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Pending Reviews</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Student submissions awaiting your evaluation.</p>

                <div class="mt-4">
                    <a href="{{ route('filament.teacher.resources.student-answers.index', ['status' => 'pending_manual_evaluation']) }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-clipboard-document-check class="w-5 h-5" />
                            <span>View Pending Reviews ({{ \App\Models\StudentAnswer::where('status', 'pending_manual_evaluation')->count() }})</span>
                        </span>
                    </a>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Recent Evaluations</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Recently evaluated student submissions.</p>

                <div class="mt-4">
                    <a href="{{ route('filament.teacher.resources.student-answers.index', ['status' => 'evaluated']) }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-success-600 hover:bg-success-500 focus:bg-success-700 focus:ring-offset-success-700">
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-check-circle class="w-5 h-5" />
                            <span>View Evaluated Submissions ({{ \App\Models\StudentAnswer::where('status', 'evaluated')->count() }})</span>
                        </span>
                    </a>
                </div>
            </div>
        </x-filament::section>
    </div>

    <div class="mt-6">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Assessment Analytics</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Overview of student performance and assessment metrics.</p>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
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
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
