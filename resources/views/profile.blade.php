<x-layouts.app>
<div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Profile Header -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 mb-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <span class="relative flex h-20 w-20 shrink-0 overflow-hidden rounded-xl">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="h-full w-full object-cover rounded-xl">
                            @else
                                <span class="flex h-full w-full items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 text-2xl font-semibold border border-emerald-500/20">
                                    {{ $user->initials() }}
                                </span>
                            @endif
                        </span>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                            <p class="text-neutral-400">{{ $user->email }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Level {{ $currentLevel }}</span>
                                <span class="text-xs text-neutral-400">{{ $currentPoints }} XP</span>
                            </div>
                        </div>
                    </div>
                    <a href="/settings/profile" class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>{{ __('Edit Profile') }}</span>
                    </a>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Activity Section -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            {{ __('Completed Challenges') }}
                        </h2>
                        <div>
                            @if($recentActivities->isEmpty())
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <div class="rounded-full bg-neutral-800 p-4 mb-4 border border-neutral-700">
                                        <svg class="w-8 h-8 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-white">{{ __('No completed challenges') }}</h3>
                                    <p class="mt-2 text-sm text-neutral-400">{{ __('Your completed challenges will appear here') }}</p>
                                    <a href="{{ route('learning') }}" class="mt-4 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-500 transition-all duration-300 text-sm font-medium flex items-center justify-center gap-2">
                                        <span>Explore Challenges</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <!-- Scrollable container for completed challenges -->
                                <div class="max-h-96 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-emerald-500 scrollbar-track-neutral-800 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                                    <div class="space-y-4 pb-2">
                                        @foreach($recentActivities as $activity)
                                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700 hover:border-emerald-500/30 transition-all duration-300 hover:bg-neutral-800 flex items-start gap-3">
                                                <div class="p-2 rounded-lg bg-emerald-500/10 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start">
                                                        <h3 class="text-sm text-white font-medium">{{ $activity->name }}</h3>
                                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/90 text-white border border-emerald-500/20 flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Completed
                                                        </span>
                                                    </div>
                                                    <p class="text-xs text-neutral-400 mt-1 line-clamp-2">{{ $activity->description }}</p>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <span class="text-xs text-neutral-400 flex items-center gap-1.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                                        </span>
                                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-800/90 text-emerald-400 border border-emerald-500/20">
                                                            {{ $activity->programming_language ?? 'PHP' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('learning') }}" class="w-full py-2.5 px-4 bg-emerald-600 text-white rounded-lg hover:bg-emerald-500 transition-all duration-300 text-sm font-medium flex items-center justify-center gap-2">
                                        <span>View All Challenges</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Achievements Section -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            {{ __('Achievements') }}
                        </h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @if($achievements->isEmpty() && $badges->isEmpty())
                                <div class="flex flex-col items-center justify-center py-8 text-center col-span-full">
                                    <div class="rounded-full bg-neutral-800 p-4 mb-4 border border-neutral-700">
                                        <svg class="w-8 h-8 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-white">{{ __('No achievements yet') }}</h3>
                                    <p class="mt-2 text-sm text-neutral-400">{{ __('Complete challenges to earn achievements') }}</p>
                                </div>
                            @else
                                @foreach($achievements as $achievement)
                                    <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700 flex flex-col items-center justify-center text-center">
                                        <div class="rounded-full bg-emerald-500/10 p-3 mb-3 border border-emerald-500/20">
                                            @if($achievement->image)
                                                <img src="{{ $achievement->image }}" alt="{{ $achievement->name }}" class="w-8 h-8">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <h3 class="text-sm font-medium text-white">{{ $achievement->name }}</h3>
                                        <p class="mt-1 text-xs text-neutral-400">{{ $achievement->description }}</p>
                                    </div>
                                @endforeach

                                @foreach($badges as $badge)
                                    <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700 flex flex-col items-center justify-center text-center">
                                        <div class="rounded-full bg-amber-500/10 p-3 mb-3 border border-amber-500/20">
                                            @if($badge->image)
                                                <img src="{{ $badge->image }}" alt="{{ $badge->name }}" class="w-8 h-8">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <h3 class="text-sm font-medium text-white">{{ $badge->name }}</h3>
                                        <p class="mt-1 text-xs text-neutral-400">{{ $badge->description }}</p>
                                        <span class="mt-2 text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-300 border border-neutral-600/20">{{ \Carbon\Carbon::parse($badge->earned_at)->format('M d, Y') }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Profile Progress Bar -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            {{ __('Profile Completion') }}
                        </h2>
                        <div class="space-y-4">
                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-neutral-300">{{ __('Profile Picture') }}</span>
                                    @if($profileCompletion['items']['profile_picture'])
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Completed</span>
                                    @else
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-500/10 text-neutral-400 border border-neutral-500/20">Not Started</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-neutral-300">{{ __('About Me Section') }}</span>
                                    @if($profileCompletion['items']['about_me'])
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Completed</span>
                                    @else
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">In Progress</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-neutral-300">{{ __('Skills & Interests') }}</span>
                                    @if($profileCompletion['items']['skills'])
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Completed</span>
                                    @else
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-500/10 text-neutral-400 border border-neutral-500/20">Not Started</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm text-neutral-300">{{ __('Overall Profile Completion') }}</span>
                                        <span class="text-sm font-medium text-white">{{ $profileCompletion['percentage'] }}%</span>
                                    </div>
                                    <div class="w-full bg-neutral-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2 rounded-full" style="width: {{ $profileCompletion['percentage'] }}%;"></div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('settings.profile') }}" class="w-full py-2 px-4 bg-emerald-500/10 text-emerald-400 rounded-lg border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors duration-300 text-sm font-medium flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Complete Your Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Stats Card -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            {{ __('Statistics') }}
                        </h2>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-emerald-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-neutral-300">{{ __('Challenges Completed') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg font-semibold text-white">{{ $completedChallenges }}</span>
                                        <span class="text-xs text-neutral-400">({{ $totalChallenges > 0 ? round(($completedChallenges / $totalChallenges) * 100) : 0 }}%)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-emerald-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-neutral-300">{{ __('Tasks Completed') }}</span>
                                    </div>
                                    <span class="text-lg font-semibold text-white">{{ $completedTasks }}</span>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-emerald-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-neutral-300">{{ __('Forum Posts') }}</span>
                                    </div>
                                    <span class="text-lg font-semibold text-white">{{ $forumPostsCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            {{ __('Quick Actions') }}
                        </h2>
                        <div class="space-y-3">
                            <a href="{{ route('courses') }}" class="flex items-center gap-3 p-3 rounded-lg bg-neutral-800/50 border border-neutral-700 hover:bg-neutral-700/50 hover:border-emerald-500/20 transition-all duration-300">
                                <div class="p-2 rounded-lg bg-emerald-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </div>
                                <span class="text-white">{{ __('Browse Courses') }}</span>
                            </a>
                            <a href="{{ route('messages') }}" class="flex items-center gap-3 p-3 rounded-lg bg-neutral-800/50 border border-neutral-700 hover:bg-neutral-700/50 hover:border-emerald-500/20 transition-all duration-300">
                                <div class="p-2 rounded-lg bg-emerald-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <span class="text-white">{{ __('Messages') }}</span>
                            </a>
                            <a href="{{ route('assignments') }}" class="flex items-center gap-3 p-3 rounded-lg bg-neutral-800/50 border border-neutral-700 hover:bg-neutral-700/50 hover:border-emerald-500/20 transition-all duration-300">
                                <div class="p-2 rounded-lg bg-emerald-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <span class="text-white">{{ __('View Assignments') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Learning Progress -->
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('Learning Progress') }}
                        </h2>
                        <div class="space-y-4">
                            @if($learningProgress->isEmpty())
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <div class="rounded-full bg-neutral-800 p-3 mb-3 border border-neutral-700">
                                        <svg class="w-6 h-6 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-white">{{ __('No courses in progress') }}</h3>
                                    <p class="mt-1 text-xs text-neutral-400">{{ __('Enroll in courses to track your progress') }}</p>
                                </div>
                            @else
                                @foreach($learningProgress as $course)
                                    <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm text-neutral-300">{{ $course['name'] }}</span>
                                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">{{ $course['progress'] }}%</span>
                                        </div>
                                        <div class="w-full bg-neutral-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2 rounded-full" style="width: {{ $course['progress'] }}%;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <a href="{{ route('learning') }}" class="w-full py-2 px-4 bg-emerald-500/10 text-emerald-400 rounded-lg border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors duration-300 text-sm font-medium flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>{{ $learningProgress->isEmpty() ? 'Start Learning' : 'Continue Learning' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>