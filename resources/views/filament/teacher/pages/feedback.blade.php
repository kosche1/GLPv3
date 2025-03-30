<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Student Feedback</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage and provide feedback on student activities and progress.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Pending Reviews</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">View and assess student submissions that need your feedback.</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Feedback History</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Access previously provided feedback and student progress reports.</p>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>