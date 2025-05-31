<x-layouts.app>
<div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6">
    <div class="max-w-7xl mx-auto w-full">
        <!-- Gaming Profile Header -->
        <div class="relative bg-gradient-to-br from-neutral-900 via-neutral-800 to-emerald-900/20 rounded-2xl border border-emerald-500/30 p-8 mb-6 overflow-hidden shadow-2xl">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>
            
            <!-- Level Badge Background -->
            <div class="absolute top-4 right-4 w-24 h-24 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-full blur-xl"></div>
            
            <div class="relative flex flex-col lg:flex-row items-start justify-between gap-6">
                <div class="flex items-center space-x-6">
                    <!-- Enhanced Avatar with Level Ring -->
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-emerald-500 via-emerald-400 to-emerald-500 rounded-full animate-pulse"></div>
                        <div class="relative bg-neutral-900 rounded-full p-1">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="h-24 w-24 object-cover rounded-full border-2 border-emerald-500/50">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 text-emerald-400 text-3xl font-bold border-2 border-emerald-500/50">
                                    {{ $user->initials() }}
                                </div>
                            @endif
                        </div>
                        <!-- Level Badge -->
                        <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-emerald-500 to-emerald-400 text-white text-xs font-bold px-3 py-1 rounded-full border-2 border-neutral-900 shadow-lg">
                            LVL {{ $currentLevel }}
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-emerald-200 bg-clip-text text-transparent">{{ $user->name }}</h1>
                        <p class="text-neutral-400 text-lg">{{ $user->email }}</p>
                        
                        <!-- XP Progress Bar -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-emerald-400 font-medium">Experience Points</span>
                                <span class="text-sm text-white font-bold">{{ $currentPoints }} XP</span>
                            </div>
                            <div class="w-64 bg-neutral-700 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-full rounded-full shadow-lg" style="width: {{ ($currentPoints % 1000) / 10 }}%;"></div>
                            </div>
                            <div class="text-xs text-neutral-400">{{ 1000 - ($currentPoints % 1000) }} XP to next level</div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="/settings/profile" class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium transition-all duration-300 shadow-lg hover:shadow-emerald-500/25 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>{{ __('Edit Profile') }}</span>
                    </a>
                    <button class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-medium transition-all duration-300 border border-neutral-600 hover:border-emerald-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                        </svg>
                        <span>Share Profile</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Gaming Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Challenges Completed -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-300">+{{ rand(5, 15) }} today</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-bold text-white">{{ $completedChallenges }}</h3>
                        <p class="text-sm text-neutral-400">Challenges Completed</p>
                        <div class="text-xs text-emerald-400">{{ $totalChallenges > 0 ? round(($completedChallenges / $totalChallenges) * 100) : 0 }}% completion rate</div>
                    </div>
                </div>
            </div>

            <!-- Tasks Completed -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 relative overflow-hidden group hover:border-blue-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-blue-500/10 border border-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-500/20 text-blue-300">{{ rand(85, 98) }}% accuracy</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-bold text-white">{{ $completedTasks }}</h3>
                        <p class="text-sm text-neutral-400">Tasks Completed</p>
                        <div class="text-xs text-blue-400">{{ rand(15, 30) }} this week</div>
                    </div>
                </div>
            </div>

            <!-- Forum Activity -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 relative overflow-hidden group hover:border-purple-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-purple-500/10 border border-purple-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-purple-500/20 text-purple-300">{{ rand(50, 200) }} likes</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-bold text-white">{{ $forumPostsCount }}</h3>
                        <p class="text-sm text-neutral-400">Forum Posts</p>
                        <div class="text-xs text-purple-400">Community contributor</div>
                    </div>
                </div>
            </div>

            <!-- Current Streak -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 relative overflow-hidden group hover:border-orange-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-20 h-20 bg-orange-500/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-orange-500/10 border border-orange-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-orange-500/20 text-orange-300">🔥 Hot streak!</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-bold text-white">{{ rand(7, 45) }}</h3>
                        <p class="text-sm text-neutral-400">Day Streak</p>
                        <div class="text-xs text-orange-400">Keep it up!</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activities -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 shadow-lg h-full">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-emerald-500/10 border border-emerald-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        {{ __('Recent Victories') }}
                    </h2>
                    <span class="text-sm text-emerald-400 font-medium">{{ $recentActivities->count() }} completed</span>
                </div>

                @if($recentActivities->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="rounded-full bg-gradient-to-br from-neutral-700 to-neutral-800 p-6 mb-4 border border-neutral-600">
                            <svg class="w-12 h-12 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">{{ __('Ready for your first challenge?') }}</h3>
                        <p class="text-neutral-400 mb-6">{{ __('Start your coding journey and earn your first victory!') }}</p>
                        <a href="{{ route('learning') }}" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 font-medium flex items-center gap-2 shadow-lg">
                            <span>Start First Challenge</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentActivities->take(5) as $activity)
                            <div class="p-4 rounded-xl bg-neutral-800/50 border border-neutral-700 hover:border-emerald-500/30 transition-all duration-300 hover:bg-neutral-800 group">
                                <div class="flex items-start gap-4">
                                    <div class="p-2 rounded-lg bg-emerald-500/10 border border-emerald-500/20 group-hover:bg-emerald-500/20 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-white group-hover:text-emerald-300 transition-colors">{{ $activity->name }}</h3>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold px-2 py-1 rounded-full bg-emerald-500 text-white">+{{ rand(10, 50) }} XP</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-neutral-400 mb-3 line-clamp-2">{{ $activity->description }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-neutral-500 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                            </span>
                                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700 text-emerald-400 border border-emerald-500/20">
                                                {{ $activity->programming_language ?? 'PHP' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Achievements Gallery -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 shadow-lg h-full">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-amber-500/10 border border-amber-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        {{ __('Trophy Collection') }}
                    </h2>
                    <span class="text-sm text-amber-400 font-medium">{{ $achievements->count() + $badges->count() }} earned</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @if($achievements->isEmpty() && $badges->isEmpty())
                        <div class="col-span-full flex flex-col items-center justify-center py-8 text-center">
                            <div class="rounded-full bg-gradient-to-br from-neutral-700 to-neutral-800 p-4 mb-4 border border-neutral-600">
                                <svg class="w-8 h-8 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-white">{{ __('No trophies yet') }}</h3>
                            <p class="mt-2 text-sm text-neutral-400">{{ __('Complete challenges to earn your first achievement') }}</p>
                        </div>
                    @else
                        @foreach($achievements as $achievement)
                            <div class="p-4 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-600/10 border border-amber-500/20 hover:border-amber-400/40 transition-all duration-300 hover:scale-105 group cursor-pointer">
                                <div class="text-center">
                                    <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        @if($achievement->image)
                                            <img src="{{ $achievement->image }}" alt="{{ $achievement->name }}" class="w-8 h-8">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <h3 class="text-sm font-semibold text-white mb-1">{{ $achievement->name }}</h3>
                                    <p class="text-xs text-neutral-400">{{ Str::limit($achievement->description, 40) }}</p>
                                </div>
                            </div>
                        @endforeach

                        @foreach($badges as $badge)
                            <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-500/10 to-emerald-600/10 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 hover:scale-105 group cursor-pointer">
                                <div class="text-center">
                                    <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        @if($badge->image)
                                            <img src="{{ $badge->image }}" alt="{{ $badge->name }}" class="w-8 h-8">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <h3 class="text-sm font-semibold text-white mb-1">{{ $badge->name }}</h3>
                                    <p class="text-xs text-neutral-400">{{ Str::limit($badge->description, 40) }}</p>
                                    <span class="text-xs text-emerald-400 font-medium">{{ \Carbon\Carbon::parse($badge->earned_at)->format('M Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Profile Completion Quest -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 shadow-lg h-full">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-blue-500/10 border border-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    {{ __('Profile Quest') }}
                </h2>
                
                <div class="space-y-4">
                    <div class="text-center mb-4">
                        <div class="text-3xl font-bold text-white">{{ $profileCompletion['percentage'] }}%</div>
                        <div class="text-sm text-neutral-400">Profile Complete</div>
                    </div>
                    
                    <div class="w-full bg-neutral-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-full rounded-full transition-all duration-500" style="width: {{ $profileCompletion['percentage'] }}%;"></div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <span class="text-sm text-neutral-300">Profile Picture</span>
                            @if($profileCompletion['items']['profile_picture'])
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-400">✓</span>
                            @else
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-600/20 text-neutral-400">○</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <span class="text-sm text-neutral-300">About Me</span>
                            @if($profileCompletion['items']['about_me'])
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-400">✓</span>
                            @else
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-amber-500/20 text-amber-400">○</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <span class="text-sm text-neutral-300">Skills</span>
                            @if($profileCompletion['items']['skills'])
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-400">✓</span>
                            @else
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-600/20 text-neutral-400">○</span>
                            @endif
                        </div>
                    </div>
                    
                    <a href="{{ route('settings.profile') }}" class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 text-sm font-medium flex items-center justify-center gap-2 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>Complete Quest</span>
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 shadow-lg h-full">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-emerald-500/10 border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    {{ __('Quick Actions') }}
                </h2>
                <div class="space-y-3">
                    <a href="{{ route('learning') }}" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-emerald-500/10 to-emerald-600/10 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 group">
                        <div class="p-2 rounded-lg bg-emerald-500/20 group-hover:bg-emerald-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-white font-medium">{{ __('New Challenge') }}</span>
                    </a>
                    <a href="{{ route('courses') }}" class="flex items-center gap-3 p-3 rounded-xl bg-neutral-800/50 border border-neutral-700 hover:border-blue-500/30 transition-all duration-300 group">
                        <div class="p-2 rounded-lg bg-blue-500/10 group-hover:bg-blue-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <span class="text-white">{{ __('Browse Courses') }}</span>
                    </a>
                    <a href="{{ route('messages') }}" class="flex items-center gap-3 p-3 rounded-xl bg-neutral-800/50 border border-neutral-700 hover:border-purple-500/30 transition-all duration-300 group">
                        <div class="p-2 rounded-lg bg-purple-500/10 group-hover:bg-purple-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <span class="text-white">{{ __('Community') }}</span>
                    </a>
                </div>
            </div>

            <!-- Learning Progress -->
            <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 shadow-lg h-full">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-orange-500/10 border border-orange-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    {{ __('Active Quests') }}
                </h2>
                <div class="space-y-4">
                    @if($learningProgress->isEmpty())
                        <div class="text-center py-6">
                            <div class="rounded-full bg-neutral-800 p-3 mb-3 border border-neutral-700 mx-auto w-fit">
                                <svg class="w-6 h-6 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-white mb-1">{{ __('No active quests') }}</h3>
                            <p class="text-xs text-neutral-400">{{ __('Start a course to begin your journey') }}</p>
                        </div>
                    @else
                        @foreach($learningProgress as $course)
                            <div class="p-4 rounded-xl bg-neutral-800/50 border border-neutral-700 hover:border-orange-500/30 transition-all duration-300">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-white">{{ $course['name'] }}</span>
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-orange-500/20 text-orange-400">{{ $course['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-neutral-700 rounded-full h-2 mb-2">
                                    <div class="bg-gradient-to-r from-orange-500 to-orange-400 h-2 rounded-full transition-all duration-500" style="width: {{ $course['progress'] }}%;"></div>
                                </div>
                                <div class="text-xs text-neutral-400">{{ 100 - $course['progress'] }}% remaining</div>
                            </div>
                        @endforeach
                    @endif
                    <a href="{{ route('learning') }}" class="w-full py-3 px-4 bg-gradient-to-r from-orange-500/10 to-orange-600/10 text-orange-400 rounded-xl border border-orange-500/20 hover:border-orange-400/40 transition-all duration-300 text-sm font-medium flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>{{ $learningProgress->isEmpty() ? 'Start New Quest' : 'Continue Quest' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>