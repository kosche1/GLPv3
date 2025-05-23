<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')


    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist.group heading="Overview" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="py-1">{{ __('Dashboard') }}</flux:navlist.item>
                <flux:navlist.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')" wire:navigate class="py-1">{{ __('Notifications') }}</flux:navlist.item>
                <flux:navlist.item icon="sparkles" :href="route('paragonz')" :current="request()->routeIs('paragonz')" wire:navigate class="py-1">{{ __('ParagonZ') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Academic Resources -->
            <flux:navlist.group heading="Academic Resources" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="academic-cap" :href="route('courses')" :current="request()->routeIs('courses')" wire:navigate class="py-1">{{ __('Courses') }}</flux:navlist.item>
                <flux:navlist.item icon="book-open" :href="route('learning-materials')" :current="request()->routeIs('learning-materials')" wire:navigate class="py-1">{{ __('Learning Materials') }}</flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('assignments')" :current="request()->routeIs('assignments')" wire:navigate class="py-1">{{ __('Tasks') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Student Management -->
            <flux:navlist.group heading="Student Management" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="user" :href="route('profile')" :current="request()->routeIs('profile')" wire:navigate class="py-1">{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item icon="calendar" :href="route('schedule')" :current="request()->routeIs('schedule')" wire:navigate class="py-1">{{ __('Schedule') }}</flux:navlist.item>
                <flux:navlist.item icon="chart-bar" :href="route('grades')" :current="request()->routeIs('dashboard')" wire:navigate class="py-1">{{ __('Grades') }}</flux:navlist.item>
                <flux:navlist.item icon="clock" :href="route('attendance.my-attendance')" :current="request()->routeIs('attendance.my-attendance')" wire:navigate class="py-1">{{ __('Attendance') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Collaborative Learning -->
            <flux:navlist.group heading="Collaborative Learning" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="user-group" :href="route('study-groups.index')" :current="request()->routeIs('study-groups.*')" wire:navigate class="py-1">{{ __('Study Groups') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Communication -->
            <flux:navlist.group heading="Communication" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="users" :href="route('forums')" :current="request()->routeIs('forums')" wire:navigate class="py-1">{{ __('Forums') }}</flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('feedback')" :current="request()->routeIs('feedback')" wire:navigate class="py-1">{{ __('Feedback') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Support & Help -->
            <flux:navlist.group heading="Support" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="question-mark-circle" :href="route('help-center')" :current="request()->routeIs('help-center')" wire:navigate class="py-1">{{ __('Help Center') }}</flux:navlist.item>
                <flux:navlist.item icon="lifebuoy" :href="route('technical-support')" :current="request()->routeIs('technical-support')" wire:navigate class="py-1">{{ __('Technical Support') }}</flux:navlist.item>
                <flux:navlist.item icon="star" :href="route('rate-us')" :current="request()->routeIs('rate-us')" wire:navigate class="py-1">{{ __('Rate Us') }}</flux:navlist.item>
            </flux:navlist.group>
            <flux:spacer />

            <!-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> -->

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                    :avatar="auth()->user()->avatar"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-2 text-sm font-normal">
                            <div class="flex flex-col items-center rounded-lg bg-linear-to-br from-indigo-100 to-purple-100 p-3 dark:from-indigo-900 dark:to-purple-900">
                                <!-- Avatar with Level Badge -->
                                <div class="relative mb-2">
                                    <div class="relative flex h-16 w-16 items-center justify-center rounded-full bg-linear-to-r from-indigo-500 to-purple-600 ring-2 ring-white dark:ring-zinc-700">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="h-full w-full rounded-full object-cover">
                                        @else
                                            <span class="text-lg font-bold text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-full bg-amber-500 text-xs font-bold text-white ring-2 ring-white dark:ring-zinc-700">
                                        {{ auth()->user()->getLevel() ?? 1 }}
                                    </div>
                                </div>
                                <!-- User Info -->
                                <div class="mb-2 text-center">
                                    <span class="block text-base font-bold">{{ auth()->user()->name }}</span>
                                    <span class="block text-xs text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Gamification Statistics -->
                    <div class="px-2 py-2">
                        <div class="grid gap-3 rounded-lg bg-linear-to-br from-neutral-50 to-neutral-100 p-3 dark:from-zinc-800 dark:to-zinc-900">
                            <!-- XP Progress Bar with Dynamic Glow -->
                            <div>
                                @php
                                    // Safety checks for admin users without experience records
                                    try {
                                        $hasLevelTable = \Schema::hasTable('levels');
                                        $hasExperienceTable = \Schema::hasTable('experiences');

                                        $currentPoints = 0;
                                        $nextLevelAt = 100;
                                        $displayLevel = auth()->user()->hasRole('admin') ? 'Admin' : '1';

                                        if ($hasLevelTable && $hasExperienceTable && method_exists(auth()->user(), 'getPoints')) {
                                            // Only try to get experience data if tables exist and method exists
                                            $currentPoints = auth()->user()->getPoints() ?? 0;

                                            if (method_exists(auth()->user(), 'nextLevelAt')) {
                                                $nextLevelThreshold = auth()->user()->nextLevelAt();
                                                $nextLevelAt = $nextLevelThreshold ?? 'MAX';
                                            }
                                        }

                                        // Ensure progress calculation doesn't cause division by zero
                                        $previousLevelAt = 0;
                                        $progress = 0;

                                        if (is_numeric($nextLevelAt) && $nextLevelAt > $previousLevelAt) {
                                            $progress = (($currentPoints - $previousLevelAt) / ($nextLevelAt - $previousLevelAt)) * 100;
                                        }
                                    } catch (\Exception $e) {
                                        // Provide safe defaults if any errors occur
                                        $currentPoints = 0;
                                        $nextLevelAt = 'N/A';
                                        $progress = 0;
                                    }
                                @endphp
                                <div class="mb-1 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Experience</span>
                                    </div>
                                    <span class="text-xs font-medium">
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $currentPoints }}</span> /
                                        <span class="text-neutral-500 dark:text-neutral-400">{{ $nextLevelAt }}</span>
                                    </span>
                                </div>

                                <div class="relative h-2.5 w-full overflow-hidden rounded-full bg-neutral-200 shadow-inner dark:bg-zinc-700">
                                    <div class="h-full rounded-full bg-linear-to-r from-emerald-400 to-emerald-500 shadow-lg"
                                        style="width: {{ min(100, max(0, $progress)) }}%; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);">
                                    </div>
                                    <!-- Animated Pulse Dot -->
                                    @if($progress < 100)
                                    <div class="absolute top-0 h-full animate-pulse rounded-full bg-white opacity-50"
                                        style="width: 10px; left: calc({{ min(98, max(0, $progress)) }}% - 5px);"></div>
                                    @endif
                                </div>
                                <div class="mt-1 text-center text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    {{ ceil(100 - $progress) }}% to next level
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Achievements Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-purple-50 to-indigo-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-purple-900/30 dark:to-indigo-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-purple-200 opacity-50 dark:bg-purple-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ auth()->user()->achievements()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-purple-600 dark:text-purple-400">Achievements</div>
                                    </div>
                                </div>

                                <!-- Badges Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-amber-50 to-orange-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-amber-900/30 dark:to-orange-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-amber-200 opacity-50 dark:bg-amber-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ auth()->user()->badges()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Badges</div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <!-- Challenges Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-red-50 to-pink-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-red-900/30 dark:to-pink-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-red-200 opacity-50 dark:bg-red-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ auth()->user()->getActiveChallenges()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Challenges</div>
                                    </div>
                                </div>

                                <!-- Streak Card -->
                                @if(class_exists('\LevelUp\Experience\Models\Streak') && method_exists(auth()->user(), 'streak'))
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-blue-50 to-sky-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-blue-900/30 dark:to-sky-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-blue-200 opacity-50 dark:bg-blue-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                                            </svg>
                                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->streak()->count() ?? 0 }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">Day Streak</div>
                                    </div>
                                </div>
                                @else
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-green-50 to-teal-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-green-900/30 dark:to-teal-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-green-200 opacity-50 dark:bg-green-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ auth()->user()->points ?? 0 }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-green-600 dark:text-green-400">Points</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">Settings</flux:menu.item>
                        <flux:menu.item href="/achievements" icon="trophy" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">My Achievements</flux:menu.item>
                        <flux:menu.item href="/challenges" icon="fire" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">Challenges</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full rounded-md text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-2 text-sm font-normal">
                            <div class="flex flex-col items-center rounded-lg bg-linear-to-br from-indigo-100 to-purple-100 p-3 dark:from-indigo-900 dark:to-purple-900">
                                <!-- Avatar with Level Badge -->
                                <div class="relative mb-2">
                                    <div class="relative flex h-16 w-16 items-center justify-center rounded-full bg-linear-to-r from-indigo-500 to-purple-600 ring-2 ring-white dark:ring-zinc-700">
                                        <span class="text-lg font-bold text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-full bg-amber-500 text-xs font-bold text-white ring-2 ring-white dark:ring-zinc-700">
                                        {{ auth()->user()->getLevel() ?? 1 }}
                                    </div>
                                </div>

                                <!-- User Info -->
                                <div class="mb-2 text-center">
                                    <span class="block text-base font-bold">{{ auth()->user()->name }}</span>
                                    <span class="block text-xs text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Gamification Statistics -->
                    <div class="px-2 py-2">
                        <div class="grid gap-3 rounded-lg bg-linear-to-br from-neutral-50 to-neutral-100 p-3 dark:from-zinc-800 dark:to-zinc-900">
                            <!-- XP Progress Bar with Dynamic Glow -->
                            <div>
                                @php
                                    // Safety checks for admin users without experience records
                                    try {
                                        $hasLevelTable = \Schema::hasTable('levels');
                                        $hasExperienceTable = \Schema::hasTable('experiences');

                                        $currentPoints = 0;
                                        $nextLevelAt = 100;
                                        $displayLevel = auth()->user()->hasRole('admin') ? 'Admin' : '1';

                                        if ($hasLevelTable && $hasExperienceTable && method_exists(auth()->user(), 'getPoints')) {
                                            // Only try to get experience data if tables exist and method exists
                                            $currentPoints = auth()->user()->getPoints() ?? 0;

                                            if (method_exists(auth()->user(), 'nextLevelAt')) {
                                                $nextLevelThreshold = auth()->user()->nextLevelAt();
                                                $nextLevelAt = $nextLevelThreshold ?? 'MAX';
                                            }
                                        }

                                        // Ensure progress calculation doesn't cause division by zero
                                        $previousLevelAt = 0;
                                        $progress = 0;

                                        if (is_numeric($nextLevelAt) && $nextLevelAt > $previousLevelAt) {
                                            $progress = (($currentPoints - $previousLevelAt) / ($nextLevelAt - $previousLevelAt)) * 100;
                                        }
                                    } catch (\Exception $e) {
                                        // Provide safe defaults if any errors occur
                                        $currentPoints = 0;
                                        $nextLevelAt = 'N/A';
                                        $progress = 0;
                                    }
                                @endphp
                                <div class="mb-1 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Experience</span>
                                    </div>
                                    <span class="text-xs font-medium">
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $currentPoints }}</span> /
                                        <span class="text-neutral-500 dark:text-neutral-400">{{ $nextLevelAt }}</span>
                                    </span>
                                </div>

                                <div class="relative h-2.5 w-full overflow-hidden rounded-full bg-neutral-200 shadow-inner dark:bg-zinc-700">
                                    <div class="h-full rounded-full bg-linear-to-r from-emerald-400 to-emerald-500 shadow-lg"
                                        style="width: {{ min(100, max(0, $progress)) }}%; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);">
                                    </div>
                                    <!-- Animated Pulse Dot -->
                                    @if($progress < 100)
                                    <div class="absolute top-0 h-full animate-pulse rounded-full bg-white opacity-50"
                                        style="width: 10px; left: calc({{ min(98, max(0, $progress)) }}% - 5px);"></div>
                                    @endif
                                </div>
                                <div class="mt-1 text-center text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    {{ ceil(100 - $progress) }}% to next level
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Achievements Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-purple-50 to-indigo-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-purple-900/30 dark:to-indigo-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-purple-200 opacity-50 dark:bg-purple-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ auth()->user()->achievements()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-purple-600 dark:text-purple-400">Achievements</div>
                                    </div>
                                </div>

                                <!-- Badges Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-amber-50 to-orange-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-amber-900/30 dark:to-orange-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-amber-200 opacity-50 dark:bg-amber-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ auth()->user()->badges()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Badges</div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <!-- Challenges Card -->
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-red-50 to-pink-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-red-900/30 dark:to-pink-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-red-200 opacity-50 dark:bg-red-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ auth()->user()->getActiveChallenges()->count() }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Challenges</div>
                                    </div>
                                </div>

                                <!-- Streak Card -->
                                @if(class_exists('\LevelUp\Experience\Models\Streak') && method_exists(auth()->user(), 'streak'))
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-blue-50 to-sky-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-blue-900/30 dark:to-sky-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-blue-200 opacity-50 dark:bg-blue-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                                            </svg>
                                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->streak()->count() ?? 0 }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">Day Streak</div>
                                    </div>
                                </div>
                                @else
                                <div class="group relative overflow-hidden rounded-lg bg-linear-to-br from-green-50 to-teal-100 p-3 shadow-xs transition-all hover:shadow-md dark:from-green-900/30 dark:to-teal-900/30">
                                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-green-200 opacity-50 dark:bg-green-700/30"></div>
                                    <div class="relative">
                                        <div class="flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ auth()->user()->points ?? 0 }}</span>
                                        </div>
                                        <div class="text-xs font-semibold uppercase tracking-wider text-green-600 dark:text-green-400">Points</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">Settings</flux:menu.item>
                        <flux:menu.item href="/achievements" icon="trophy" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">My Achievements</flux:menu.item>
                        <flux:menu.item href="/challenges" icon="fire" wire:navigate class="rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800">Challenges</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full rounded-md text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @auth
            @livewire('session-timeout')
        @endauth

        @stack('styles')
        @fluxScripts
        @stack('scripts')
    </body>
</html>
