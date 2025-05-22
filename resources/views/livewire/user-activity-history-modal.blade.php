<div>
    @if($isOpen)
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        x-data
        x-init="$el.classList.add('opacity-0'); setTimeout(() => { $el.classList.replace('opacity-0', 'opacity-100'); }, 100)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-md p-6 mx-auto bg-neutral-800 rounded-xl shadow-xl border border-neutral-700 overflow-hidden"
            x-data
            x-init="$el.classList.add('scale-95', 'opacity-0'); setTimeout(() => { $el.classList.replace('scale-95', 'scale-100'); $el.classList.replace('opacity-0', 'opacity-100'); }, 150)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Background Effects -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_70%)] opacity-70"></div>
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/0 via-emerald-500/5 to-emerald-500/0 rounded-xl blur-xl"></div>

            <!-- Close Button -->
            <button
                wire:click="closeModal"
                class="absolute top-3 right-3 text-gray-400 hover:text-white transition-colors duration-200 z-10"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="relative z-10">
                <!-- Header -->
                <div class="flex items-center mb-4">
                    <div class="relative mr-3">
                        <div class="absolute -inset-1 bg-emerald-500/20 rounded-full blur-sm opacity-70"></div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-lg font-bold text-white shadow-lg overflow-hidden relative">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.25),transparent_50%)] opacity-70"></div>
                            <div class="relative z-10">{{ substr($userName, 0, 1) }}</div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $userName }}</h3>
                        <div class="flex items-center text-xs text-gray-400">
                            <span>Level {{ $userLevel }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ number_format($userPoints) }} XP</span>
                        </div>
                    </div>
                </div>

                <h4 class="text-sm font-medium text-emerald-400 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Activity History
                </h4>

                <!-- Loading State -->
                @if($loading)
                <div class="py-8">
                    <div class="flex justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-emerald-500"></div>
                    </div>
                    <p class="text-center text-gray-400 text-sm mt-3">Loading activity history...</p>
                </div>
                @else
                    <!-- Activity Timeline -->
                    <div class="max-h-[350px] overflow-y-auto pr-2 -mr-2">
                        @if(count($activityHistory) > 0)
                            <div class="space-y-3">
                                @foreach($activityHistory as $activity)
                                    <div class="relative pl-6 pb-3 group">
                                        <!-- Timeline connector -->
                                        @if(!$loop->last)
                                            <div class="absolute left-[9px] top-[18px] bottom-0 w-0.5 bg-neutral-700 group-hover:bg-emerald-500/30 transition-colors duration-300"></div>
                                        @endif

                                        <!-- Timeline dot -->
                                        <div class="absolute left-0 top-[6px] h-[18px] w-[18px] rounded-full border-2
                                            @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                @if($activity['notification_type'] === 'achievement')
                                                    border-yellow-500 bg-yellow-500/20
                                                @elseif($activity['notification_type'] === 'grade')
                                                    border-emerald-500 bg-emerald-500/20
                                                @elseif($activity['notification_type'] === 'challenge')
                                                    border-blue-500 bg-blue-500/20
                                                @elseif($activity['notification_type'] === 'reward')
                                                    border-orange-500 bg-orange-500/20
                                                @else
                                                    border-purple-500 bg-purple-500/20
                                                @endif
                                            @else
                                                {{ $activity['type'] === 'add' ? 'border-emerald-500 bg-emerald-500/20' :
                                                   ($activity['type'] === 'remove' ? 'border-red-500 bg-red-500/20' :
                                                   ($activity['type'] === 'level_up' ? 'border-yellow-500 bg-yellow-500/20' :
                                                   'border-blue-500 bg-blue-500/20')) }}
                                            @endif
                                            group-hover:scale-110 transition-transform duration-300">
                                        </div>

                                        <!-- Activity content -->
                                        <div class="bg-neutral-700/20 border border-neutral-700/50 rounded-lg p-3 group-hover:bg-neutral-700/30 group-hover:border-emerald-500/30 transition-colors duration-300">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="flex items-center">
                                                        <!-- Activity type icon -->
                                                        @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                            @if($activity['notification_type'] === 'achievement')
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif($activity['notification_type'] === 'grade')
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif($activity['notification_type'] === 'challenge')
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                                                </svg>
                                                            @elseif($activity['notification_type'] === 'reward')
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd" />
                                                                    <path d="M9 11H3v5a2 2 0 002 2h4v-7zm2 7h4a2 2 0 002-2v-5h-6v7z" />
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                                </svg>
                                                            @endif
                                                        @elseif($activity['type'] === 'add')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif($activity['type'] === 'remove')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif($activity['type'] === 'level_up')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif

                                                        <!-- Activity type label -->
                                                        <span class="text-sm font-medium
                                                            @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                                @if($activity['notification_type'] === 'achievement')
                                                                    text-yellow-400
                                                                @elseif($activity['notification_type'] === 'grade')
                                                                    text-emerald-400
                                                                @elseif($activity['notification_type'] === 'challenge')
                                                                    text-blue-400
                                                                @elseif($activity['notification_type'] === 'reward')
                                                                    text-orange-400
                                                                @else
                                                                    text-purple-400
                                                                @endif
                                                            @else
                                                                {{ $activity['type'] === 'add' ? 'text-emerald-400' :
                                                                   ($activity['type'] === 'remove' ? 'text-red-400' :
                                                                   ($activity['type'] === 'level_up' ? 'text-yellow-400' :
                                                                   'text-blue-400')) }}
                                                            @endif
                                                            ">
                                                            @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                                @if($activity['notification_type'] === 'achievement')
                                                                    Achievement
                                                                @elseif($activity['notification_type'] === 'grade')
                                                                    Task Approved
                                                                @elseif($activity['notification_type'] === 'challenge')
                                                                    Challenge
                                                                @elseif($activity['notification_type'] === 'reward')
                                                                    Reward
                                                                @else
                                                                    Notification
                                                                @endif
                                                            @else
                                                                {{ $activity['type'] === 'add' ? 'Earned Points' :
                                                                   ($activity['type'] === 'remove' ? 'Lost Points' :
                                                                   ($activity['type'] === 'level_up' ? 'Level Up' :
                                                                   'Reset')) }}
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <!-- Activity reason -->
                                                    @if($activity['reason'])
                                                        @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification' && isset($activity['link']) && $activity['link'])
                                                            <p class="text-xs text-gray-300 mt-1">
                                                                {{ $activity['reason'] }}
                                                                <a href="{{ $activity['link'] }}" class="text-emerald-400 hover:text-emerald-300 ml-1 inline-flex items-center">
                                                                    <span>View</span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-0.5" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </a>
                                                            </p>
                                                        @else
                                                            <p class="text-xs text-gray-300 mt-1">{{ $activity['reason'] }}</p>
                                                        @endif
                                                    @endif
                                                </div>

                                                <!-- Points -->
                                                <div class="text-xs font-mono px-2 py-1 rounded-full
                                                    @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                        @if($activity['notification_type'] === 'achievement')
                                                            bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                        @elseif($activity['notification_type'] === 'grade')
                                                            bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                                        @elseif($activity['notification_type'] === 'challenge')
                                                            bg-blue-500/20 text-blue-400 border border-blue-500/30
                                                        @elseif($activity['notification_type'] === 'reward')
                                                            bg-orange-500/20 text-orange-400 border border-orange-500/30
                                                        @else
                                                            bg-purple-500/20 text-purple-400 border border-purple-500/30
                                                        @endif
                                                    @else
                                                        {{ $activity['type'] === 'add' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' :
                                                           ($activity['type'] === 'remove' ? 'bg-red-500/20 text-red-400 border border-red-500/30' :
                                                           ($activity['type'] === 'level_up' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' :
                                                           'bg-blue-500/20 text-blue-400 border border-blue-500/30')) }}
                                                    @endif
                                                    ">
                                                    @if(isset($activity['activity_type']) && $activity['activity_type'] === 'notification')
                                                        @if($activity['points'] > 0)
                                                            +{{ $activity['points'] }} XP
                                                        @elseif($activity['notification_type'] === 'grade' || $activity['notification_type'] === 'achievement')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                    @else
                                                        {{ $activity['type'] === 'add' ? '+' : ($activity['type'] === 'remove' ? '-' : '') }}{{ abs($activity['points']) }} XP
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Timestamp -->
                                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                <span title="{{ $activity['date'] }}">{{ $activity['time_ago'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-8 text-center">
                                <div class="h-16 w-16 rounded-full bg-neutral-700/30 flex items-center justify-center mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm">No activity history available</p>
                                <p class="text-gray-500 text-xs mt-1">Activities will appear here as you earn points</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
