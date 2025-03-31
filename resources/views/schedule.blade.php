<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">   
        <div class="mx-auto w-full max-w-7xl">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('Schedule') }}
                </h1>
                <div class="flex rounded-lg shadow-sm" role="group">
                    <button class="px-4 py-2 text-sm font-medium rounded-l-lg border bg-emerald-500 text-white border-emerald-600">
                        Weekly
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-r-lg border-t border-r border-b bg-neutral-800 text-neutral-300 border-neutral-700 hover:bg-neutral-700 transition-colors duration-300">
                        Monthly
                    </button>
                </div>
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button class="p-2 rounded-lg bg-neutral-800 border border-neutral-700 hover:bg-neutral-700 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-white">March 10 - March 16, 2025</h2>
                    <button class="p-2 rounded-lg bg-neutral-800 border border-neutral-700 hover:bg-neutral-700 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <button class="px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Event</span>
                </button>
            </div>
            
            <div class="rounded-xl overflow-hidden bg-gradient-to-br from-neutral-800 to-neutral-900 border border-neutral-700 transition-all duration-300 hover:shadow-lg hover:shadow-neutral-900/50 hover:border-emerald-500/30">
                <div class="divide-y divide-neutral-700">
                    <!-- Monday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-emerald-500/10 border border-emerald-500/20">
                                <span class="font-medium text-white">10</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Monday</p>
                                <p class="text-sm text-neutral-400">10 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <div class="p-3 rounded-lg border bg-emerald-500/10 text-emerald-400 border-emerald-500/20 transition-all duration-300 hover:scale-[1.02] hover:bg-emerald-500/15 hover:border-emerald-500/30">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">Project Kickoff</h3>
                                        <p class="text-xs text-neutral-400 mt-1">Meeting with the development team to discuss project goals</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full bg-neutral-800 border border-neutral-700">09:00 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tuesday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">11</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Tuesday</p>
                                <p class="text-sm text-neutral-400">11 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-neutral-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Wednesday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">12</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Wednesday</p>
                                <p class="text-sm text-neutral-400">12 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <div class="p-3 rounded-lg border bg-blue-500/10 text-blue-400 border-blue-500/20 transition-all duration-300 hover:scale-[1.02] hover:bg-blue-500/15 hover:border-blue-500/30">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">Design Review</h3>
                                        <p class="text-xs text-neutral-400 mt-1">Review UI/UX designs with the design team</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full bg-neutral-800 border border-neutral-700">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thursday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">13</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Thursday</p>
                                <p class="text-sm text-neutral-400">13 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-neutral-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Friday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">14</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Friday</p>
                                <p class="text-sm text-neutral-400">14 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <p class="text-sm text-neutral-500 italic">No events scheduled</p>
                        </div>
                    </div>

                    <!-- Saturday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">15</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Saturday</p>
                                <p class="text-sm text-neutral-400">15 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <div class="p-3 rounded-lg border bg-purple-500/10 text-purple-400 border-purple-500/20 transition-all duration-300 hover:scale-[1.02] hover:bg-purple-500/15 hover:border-purple-500/30">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">Backend Development</h3>
                                        <p class="text-xs text-neutral-400 mt-1">Working on API endpoints and database models</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full bg-neutral-800 border border-neutral-700">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sunday -->
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-neutral-800 border border-neutral-700">
                                <span class="font-medium text-white">16</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">Sunday</p>
                                <p class="text-sm text-neutral-400">16 March 2025</p>
                            </div>
                        </div>
                        
                        <div class="ml-16 space-y-3">
                            <div class="p-3 rounded-lg border bg-amber-500/10 text-amber-400 border-amber-500/20 transition-all duration-300 hover:scale-[1.02] hover:bg-amber-500/15 hover:border-amber-500/30">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">Code Review</h3>
                                        <p class="text-xs text-neutral-400 mt-1">Review pull requests and code quality</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full bg-neutral-800 border border-neutral-700">02:30 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            <nav class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 rounded-md bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <a href="#" class="px-3 py-1 rounded-md bg-emerald-500 text-white">1</a>
                <a href="#" class="px-3 py-1 rounded-md bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">2</a>
                <a href="#" class="px-3 py-1 rounded-md bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">3</a>
                <a href="#" class="px-3 py-1 rounded-md bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</x-layouts.app>