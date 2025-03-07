<x-layouts.app>
    <div class="p-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Schedule') }}</h1>
                
                <div class="flex items-center space-x-3">
                    <button class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Add Event
                    </button>
                    <div class="relative">
                        <button class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between border-b border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-center space-x-4">
                        <button class="rounded-lg border border-zinc-200 p-2 text-zinc-500 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">March 2024</h2>
                        <button class="rounded-lg border border-zinc-200 p-2 text-zinc-500 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-zinc-800 dark:bg-zinc-700 dark:hover:bg-zinc-600">Today</button>
                        <div class="relative">
                            <button class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                Month
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-px overflow-hidden bg-zinc-200 dark:bg-zinc-700">
                    <!-- Days of Week -->
                    <div class="grid grid-cols-7 gap-4">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="bg-white p-3 text-center text-sm font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>
                    
                    <!-- Previous Month Days (example) -->
                    @for($i = 25; $i <= 29; $i++)
                        <div class="group min-h-[120px] bg-white p-2 transition-colors hover:bg-zinc-50 dark:bg-zinc-800 dark:hover:bg-zinc-750">
                            <span class="text-sm text-zinc-400 dark:text-zinc-500">{{ $i }}</span>
                        </div>
                    @endfor

                    <!-- Current Month Days -->
                    @for($i = 1; $i <= 31; $i++)
                        <div class="group min-h-[120px] bg-white p-2 transition-colors hover:bg-zinc-50 dark:bg-zinc-800 dark:hover:bg-zinc-750">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium {{ $i === 15 ? 'flex h-7 w-7 items-center justify-center rounded-full bg-zinc-900 text-white dark:bg-zinc-600' : 'text-zinc-900 dark:text-zinc-200' }}">{{ $i }}</span>
                                
                                @if($i === 8 || $i === 22)
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                @endif
                            </div>
                            
                            <!-- Example Events -->
                            @if($i === 8)
                                <div class="mt-1 rounded-md border-l-2 border-blue-500 bg-blue-50 p-1.5 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    <div class="flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        9:00 AM - Meeting
                                    </div>
                                </div>
                            @endif
                            
                            @if($i === 15)
                                <div class="mt-1 rounded-md border-l-2 border-indigo-500 bg-indigo-50 p-1.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    <div class="flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                        10:30 AM - Team Sync
                                    </div>
                                </div>
                                <div class="mt-1 rounded-md border-l-2 border-emerald-500 bg-emerald-50 p-1.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <div class="flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        2:00 PM - Client Call
                                    </div>
                                </div>
                            @endif
                            
                            @if($i === 22)
                                <div class="mt-1 rounded-md border-l-2 border-rose-500 bg-rose-50 p-1.5 text-xs font-medium text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">
                                    <div class="flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        11:00 AM - Deadline
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endfor

                    <!-- Next Month Days (example) -->
                    @for($i = 1; $i <= 5; $i++)
                        <div class="group min-h-[120px] bg-white p-2 transition-colors hover:bg-zinc-50 dark:bg-zinc-800 dark:hover:bg-zinc-750">
                            <span class="text-sm text-zinc-400 dark:text-zinc-500">{{ $i }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>