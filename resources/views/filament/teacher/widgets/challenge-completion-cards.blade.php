<x-filament::section>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold tracking-tight">Challenge Completion Rates</h2>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach($this->getChallenges() as $challenge)
            @php
                $completionPercentage = $challenge->total_participants > 0 
                    ? ($challenge->completed_count / $challenge->total_participants) * 100 
                    : 0;
                
                $colorClass = match(true) {
                    $completionPercentage >= 75 => 'text-success-600 dark:text-success-400',
                    $completionPercentage >= 50 => 'text-primary-600 dark:text-primary-400',
                    $completionPercentage >= 25 => 'text-warning-600 dark:text-warning-400',
                    default => 'text-danger-600 dark:text-danger-400',
                };
                
                $bgColorClass = match(true) {
                    $completionPercentage >= 75 => 'bg-success-500',
                    $completionPercentage >= 50 => 'bg-primary-500',
                    $completionPercentage >= 25 => 'bg-warning-500',
                    default => 'bg-danger-500',
                };
            @endphp
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition hover:shadow-md">
                <div class="p-4">
                    <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2 truncate" title="{{ $challenge->name }}">
                        {{ $challenge->name }}
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-2 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Participants</p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $challenge->total_participants }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-2 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Completed</p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $challenge->completed_count }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Completion Rate</span>
                            <span class="font-medium {{ $colorClass }}">{{ number_format($completionPercentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                            <div class="{{ $bgColorClass }} h-2.5 rounded-full" style="width: {{ min(100, $completionPercentage) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament::section>
