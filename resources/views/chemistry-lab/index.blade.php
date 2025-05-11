<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Chemistry Lab Simulator</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('subjects.specialized.stem') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Back to STEM</span>
                </a>
            </div>
        </div>

        <!-- Description Section -->
        <div class="p-4 bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-semibold text-white mb-2">About Chemistry Lab</h2>
                    <p class="text-sm text-neutral-300 leading-relaxed">
                        Welcome to the virtual Chemistry Lab! Conduct experiments, mix chemicals, and learn about chemical reactions in a safe, interactive environment. Complete challenges to earn points and demonstrate your chemistry knowledge.
                    </p>
                </div>
                <div class="flex-none">
                    <a href="{{ route('subjects.specialized.stem.chemistry-lab.free-experiment') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                        Free Experiment
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Challenge Grid -->
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" id="challenge-grid">
            <!-- Challenge Cards -->
            @if(count($challenges) > 0)
                @foreach($challenges as $challenge)
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="h-44 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-neutral-900/90 z-10"></div>
                        <div class="absolute bottom-3 left-3 z-20">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $challenge->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : 
                                   ($challenge->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800') }}">
                                {{ ucfirst($challenge->difficulty_level) }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3 z-20">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $challenge->points_reward }} Points
                            </span>
                        </div>
                        <img src="{{ asset('images/chemistry-lab/' . ($challenge->id % 5 + 1) . '.jpg') }}" alt="{{ $challenge->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $challenge->title }}</h3>
                        <p class="text-neutral-400 text-sm mb-4 flex-1">{{ Str::limit($challenge->description, 100) }}</p>
                        <div class="mt-4 pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.stem.chemistry-lab.challenge', ['challenge' => $challenge]) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white {{ isset($completedChallenges) && in_array($challenge->id, $completedChallenges ?? []) ? 'bg-blue-600 hover:bg-blue-500' : 'bg-emerald-600 hover:bg-emerald-500' }} rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                @if(isset($completedChallenges) && in_array($challenge->id, $completedChallenges ?? []))
                                    View Challenge
                                @else
                                    Start Challenge
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4 bg-neutral-800/50 rounded-xl border border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-neutral-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-xl font-medium text-white mb-2">No challenges found</h3>
                    <p class="text-neutral-400 text-center mb-6">We're currently developing new chemistry challenges. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>

