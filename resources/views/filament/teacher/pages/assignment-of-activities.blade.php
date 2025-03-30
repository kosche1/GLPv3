<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Assignment of Activities</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage and assign learning activities to your students.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Active Assignments</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">View and manage currently assigned activities and their progress.</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Activity Library</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Browse and select from available learning activities to assign.</p>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>