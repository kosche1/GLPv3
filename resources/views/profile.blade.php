<x-layouts.app>
    <!-- <div class="min-h-screen bg-white dark:bg-zinc-800 p-6"> -->
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg" id="app">
        <div class="max-w-7xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 mb-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="relative flex h-16 w-16 shrink-0 overflow-hidden rounded-xl">
                            <span class="flex h-full w-full items-center justify-center rounded-xl bg-neutral-200 text-black text-xl font-semibold dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <div>
                            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h1>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <flux:button variant="primary" icon="pencil" wire:navigate href="/settings/profile">{{ __('Edit Profile') }}</flux:button>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Activity Section -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Recent Activity') }}</h2>
                        <div class="space-y-4">
                            <div class="flex flex-col items-center justify-center py-8 text-center">
                                <div class="rounded-full bg-zinc-100 dark:bg-zinc-800 p-3 mb-4">
                                    <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('No recent activity') }}</h3>
                                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Your recent activities will appear here') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievements Section -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Achievements') }}</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="flex flex-col items-center justify-center py-8 text-center col-span-full">
                                <div class="rounded-full bg-zinc-100 dark:bg-zinc-800 p-3 mb-4">
                                    <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('No achievements yet') }}</h3>
                                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Complete tasks to earn achievements') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Section -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Notifications') }}</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('New comment on your post') }}</span>
                                <span class="text-xs text-zinc-400 dark:text-zinc-500">2 hours ago</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('New message received') }}</span>
                                <span class="text-xs text-zinc-400 dark:text-zinc-500">1 day ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Progress Bar -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Profile Completion') }}</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Profile Picture') }}</span>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">Completed</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('About Me Section') }}</span>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">In Progress</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Overall Profile Completion') }}</span>
                                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2 mt-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 60%;"></div>
                                </div>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">60%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Stats Card -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Statistics') }}</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Courses Enrolled') }}</span>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Assignments Completed') }}</span>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Forum Posts') }}</span>
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-zinc-200 dark:border-neutral-700 p-6 overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg dark:hover:shadow-neutral-700/20">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Quick Actions') }}</h2>
                        <div class="space-y-2">
                            <flux:button variant="outline" icon="academic-cap" class="w-full justify-start" wire:navigate href="{{ route('courses') }}">{{ __('Browse Courses') }}</flux:button>
                            <flux:button variant="outline" icon="chat-bubble-left-right" class="w-full justify-start" wire:navigate href="{{ route('messages') }}">{{ __('Messages') }}</flux:button>
                            <flux:button variant="outline" icon="document-text" class="w-full justify-start" wire:navigate href="{{ route('assignments') }}">{{ __('View Assignments') }}</flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
