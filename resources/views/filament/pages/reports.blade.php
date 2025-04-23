<x-filament-panels::page>
    <x-filament::section>
        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                    <button
                        wire:click="setActiveTab('daily')"
                        class="{{ $activeTab === 'daily' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Daily Report
                    </button>
                    <button
                        wire:click="setActiveTab('weekly')"
                        class="{{ $activeTab === 'weekly' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Weekly Report
                    </button>
                    <button
                        wire:click="setActiveTab('monthly')"
                        class="{{ $activeTab === 'monthly' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Monthly Report
                    </button>
                </nav>
            </div>
        </div>

        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
