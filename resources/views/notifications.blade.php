<x-layouts.app>
    <!-- <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl"> -->
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg" id="app">
        <div class="mx-auto w-full max-w-7xl p-4 md:p-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Notifications') }}</h1>
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
                        <input type="text" placeholder="Search notifications..." 
                            class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                    </div>

                    <!-- Filter Dropdown -->
                    <div x-data="{ status: 'all' }">
                        <select class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" 
                                x-model="status" 
                                @change="$wire.setStatus(status)">
                            <option value="all">All Notifications</option>
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                            <option value="important">Important</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="mt-8 space-y-4">
                @foreach (\App\Models\Challenge::all() as $challenge)
                <div class="rounded-xl border border-neutral-700 bg-neutral-800 p-6 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500" x-bind:class="{ 'bg-green-500': $challenge->status === 'read', 'bg-emerald-500': $challenge->status === 'unread' }"></span>
                            <span class="text-base font-medium text-white">{{ $challenge->name }}</span>
                        </div>
                        <span class="text-sm text-neutral-400">{{ $challenge->start_date->diffForHumans() }}</span>
                    </div>
                    <p class="mb-4 text-sm text-neutral-300 leading-relaxed">{{ $challenge->description }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="inline-flex items-center rounded-full border border-neutral-700 px-2.5 py-0.5 text-xs font-medium text-neutral-400">{{ $challenge->challenge_type }}</span>
                        </div>
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="inline-flex items-center text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors">
                            View Course
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex items-center justify-center">
                <nav class="flex flex-wrap gap-2" aria-label="Pagination">
                    <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors">Previous</a>
                    <a href="#" class="rounded-lg border border-neutral-600 bg-neutral-700 px-4 py-2 text-sm font-medium text-white transition-colors">1</a>
                    <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors">2</a>
                    <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors">3</a>
                    <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors">Next</a>
                </nav>
            </div>
        </div>
    </div>
</x-layouts.app>