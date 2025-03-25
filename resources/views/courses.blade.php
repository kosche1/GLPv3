<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h1 class="text-2xl font-bold text-white">Courses</h1>
            </div>
            
            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row items-center gap-4">
            <!-- Search Input -->
            <div class="relative w-full md:w-auto">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" placeholder="Search courses..." 
                    class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
            </div>

            <!-- Filter Dropdown -->
            <div x-data="{ status: 'all' }">
                <select class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600" 
                        x-model="status" 
                        @change="$wire.setStatus(status)">
                    <option value="all">All Courses</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="upcoming">Upcoming</option>
                </select>
            </div>
        </div>

        </div>
    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Course Progress Overview -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-6 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-neutral-700/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-700/90">
                            <h3 class="text-lg font-medium text-white">Current Courses</h3>
                            <p class="text-3xl font-bold text-white mt-2">{{ $challenges->where('status', 'active')->count() }}</p>
                            <p class="text-sm text-neutral-400">Active Enrollments</p>
                        </div>
                        <div class="p-4 bg-neutral-700/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-700/90">
                            <h3 class="text-lg font-medium text-white">Average Grade</h3>
                            <p class="text-3xl font-bold text-white mt-2">{{ $challenges->avg('grade') ?? 0 }}%</p>
                            <p class="text-sm text-neutral-400">Across All Courses</p>
                        </div>
                        <div class="p-4 bg-neutral-700/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-700/90">
                            <h3 class="text-lg font-medium text-white">Completion Rate</h3>
                            <p class="text-3xl font-bold text-white mt-2">{{ $challenges->where('completed', true)->count() / $challenges->count() * 100 ?? 0 }}%</p>
                            <p class="text-sm text-neutral-400">Overall Progress</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Course Cards -->
            @foreach($challenges as $challenge)
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-4">
                    <div class="h-40 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden">
                        @if($challenge->image)
                            <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full">
                        @else
                            <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $challenge->name }}</h3>
                        <p class="mt-2 text-sm text-neutral-400">{{ $challenge->description }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-emerald-400">{{ $challenge->difficulty_level }}</span>
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300">Start →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 flex items-center justify-center">
        <nav class="flex space-x-2" aria-label="Pagination">
            <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-all duration-300">Previous</a>
            <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-white hover:bg-neutral-700 transition-all duration-300">1</a>
            <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-all duration-300">2</a>
            <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-all duration-300">3</a>
            <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-all duration-300">Next</a>
        </nav>
    </div>
</x-layouts.app>

