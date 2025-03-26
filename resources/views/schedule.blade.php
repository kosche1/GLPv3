<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mx-auto w-full max-w-7xl p-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('Schedule') }}
                </h1>
                <div class="flex rounded-lg shadow-sm" role="group">
                    <button class="px-4 py-2 text-sm font-medium rounded-l-lg border bg-zinc-100 text-zinc-900 border-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700">
                        Weekly
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-r-lg border-t border-r border-b bg-white text-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:bg-zinc-900 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        Monthly
                    </button>
                </div>
                
                <!-- <div class="flex items-center space-x-3">
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
                </div> -->
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <!-- <button class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-700 dark:text-zinc-300" aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-700 dark:text-zinc-300" aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button> -->
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">March 10 - March 16, 2025</h2>
                </div>
            </div>
            
            <div class="border rounded-xl overflow-hidden bg-white dark:bg-neutral-800 border-zinc-200 dark:border-neutral-700 transition-all duration-300 hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600">
                <div class="divide-y divide-zinc-200 dark:divide-neutral-700">
                    <!-- Monday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">10</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Monday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">10 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <div class="p-3 rounded-lg border bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-900/50 dark:text-rose-300 dark:border-rose-900 transition-all duration-300 hover:scale-[1.02]">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-medium">Project Kickoff</h3>
                                    <span class="text-xs">09:00 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tuesday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">11</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Tuesday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">11 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-zinc-400 dark:text-zinc-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Wednesday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">12</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Wednesday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">12 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                        <div class="p-3 rounded-lg border bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-900/50 dark:text-rose-300 dark:border-rose-900 transition-all duration-300 hover:scale-[1.02]">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-medium">Design Review</h3>
                                    <span class="text-xs">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thursday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">13</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Thursday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">13 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-zinc-400 dark:text-zinc-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Friday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">14</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Friday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">14 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-zinc-400 dark:text-zinc-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Saturday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">15</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Saturday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">15 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                        <div class="p-3 rounded-lg border bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-900/50 dark:text-rose-300 dark:border-rose-900 transition-all duration-300 hover:scale-[1.02]">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-medium">Backend Development</h3>
                                    <span class="text-xs">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sunday -->
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-zinc-100 dark:bg-neutral-800">
                                <span class="font-medium text-zinc-900 dark:text-white">16</span>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">Saturday</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">16 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                        <div class="p-3 rounded-lg border bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-900/50 dark:text-rose-300 dark:border-rose-900 transition-all duration-300 hover:scale-[1.02]">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-medium">Design Review</h3>
                                    <span class="text-xs">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-center">
            <nav class="flex space-x-2" aria-label="Pagination">
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">Previous</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-white transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">1</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">2</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">3</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">Next</a>
            </nav>
        </div>
    </div>
</x-layouts.app>