
<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Applied Subjects</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('learning') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to Learning Portal</span>
                </a>
            </div>
        </div>

        <!-- Description Section -->
        <div class="p-4 bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-shrink-0">
                    <h2 class="text-lg font-semibold text-white">About Applied Subjects</h2>
                    <p class="text-sm text-neutral-300">
                        Practical disciplines bridging theory and real-world applications.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 md:ml-auto">
                    <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium text-emerald-400">English for Academic and Professional Purposes</span>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium text-emerald-400">Filipino sa Piling Larangan</span>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium text-emerald-400">Empowerment Technologies</span>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium text-emerald-400">Entrepreneurship</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-semibold text-white">Available Applied Courses</h2>
                <span class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full text-xs font-medium">
                    <span id="result-count">{{ count($challenges) }}</span> results
                </span>
            </div>
        </div>

        <!-- Course Grid -->
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" id="challenge-grid">
            <!-- Course Cards -->
            @if(count($challenges) > 0)
                @foreach($challenges as $challenge)
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30" data-category="{{ $challenge->category_id }}" data-language="{{ strtolower($challenge->programming_language) }}">
                    <div class="h-44 overflow-hidden relative">
                        @if($challenge->image)
                            <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-emerald-500/10 flex items-center justify-center">
                                <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Subject Type Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="bg-neutral-800/90 text-emerald-400 text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-500/20">
                                Applied Subject
                            </span>
                        </div>

                        <!-- Status Badges -->
                        @if(isset($expiredChallenges) && in_array($challenge->id, $expiredChallenges ?? []))
                        <div class="absolute top-3 left-3">
                            <span class="bg-red-500 text-white text-xs font-medium px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Expired
                            </span>
                        </div>
                        @elseif(isset($completedChallenges) && in_array($challenge->id, $completedChallenges ?? []))
                        <div class="absolute top-3 left-3">
                            <span class="bg-emerald-500 text-white text-xs font-medium px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Completed
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col grow">
                        <div class="grow space-y-3">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $challenge->name }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    {{ $challenge->difficulty_level }}
                                </span>
                            </div>

                            <p class="text-sm text-neutral-400 line-clamp-2">{{ $challenge->description }}</p>

                            <!-- Course Info -->
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $challenge->duration ?? 'No end date' }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span>{{ $challenge->rating ?? '4.8' }} ({{ $challenge->reviews ?? '24' }})</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-neutral-700">
                            @if(isset($expiredChallenges) && in_array($challenge->id, $expiredChallenges ?? []))
                                <div class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-neutral-400 bg-neutral-700 rounded-lg cursor-not-allowed">
                                    Challenge Expired
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif(isset($lockedChallenges) && in_array($challenge->id, $lockedChallenges ?? []))
                                <div class="inline-flex flex-col items-center justify-center w-full px-4 py-2.5 text-sm font-medium bg-neutral-700 rounded-lg cursor-not-allowed">
                                    <div class="flex items-center justify-center text-amber-400 mb-1">
                                        <span>Level {{ $challenge->required_level }} Required</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div class="text-xs text-neutral-400">
                                        Reach level {{ $challenge->required_level }} to unlock this challenge
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white {{ isset($completedChallenges) && in_array($challenge->id, $completedChallenges ?? []) ? 'bg-blue-600 hover:bg-blue-500' : 'bg-emerald-600 hover:bg-emerald-500' }} rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                    @if(isset($completedChallenges) && in_array($challenge->id, $completedChallenges ?? []))
                                        View Course
                                    @else
                                        Start Challenge
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center p-10 bg-neutral-800/50 rounded-xl border border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-xl font-medium text-white mb-2">No courses found</h3>
                    <p class="text-neutral-400 text-center mb-6">We're currently developing new applied subject courses. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
