<x-filament::section>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold tracking-tight">Top Performing Students</h2>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        @foreach($this->getTopStudents() as $student)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition hover:shadow-md">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                    <span class="text-sm font-medium text-primary-700 dark:text-primary-300">{{ substr($student->name, 0, 2) }}</span>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <div class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-2 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Level</p>
                            <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">{{ $student->level_id }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-2 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">XP Points</p>
                            <p class="text-lg font-semibold text-success-600 dark:text-success-400">{{ number_format($student->experience_points) }}</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>Completed Tasks</span>
                            <span>{{ $student->student_answers_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            @php
                                $progressPercentage = min(100, ($student->student_answers_count / max(1, 50)) * 100);
                            @endphp
                            <div class="bg-success-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament::section>
