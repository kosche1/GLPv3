<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <!-- Monaco Editor -->
        <script>
            // Configure Monaco loader
            window.MonacoEnvironment = {
                getWorkerUrl: function(workerId, label) {
                    return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                        self.MonacoEnvironment = {
                            baseUrl: '${window.location.origin}/js/monaco-editor/min/'
                        };
                        importScripts('${window.location.origin}/js/monaco-editor/min/vs/base/worker/workerMain.js');
                    `)}`;
                }
            };
        </script>
        <script src="{{ asset('js/monaco-editor/min/vs/loader.js') }}"></script>
        <script>
            require.config({
                paths: {
                    'vs': '{{ asset('js/monaco-editor/min/vs') }}'
                }
            });

            // Preload Monaco features for faster initialization
            if (document.querySelector('#monaco-editor-container')) {
                require(['vs/editor/editor.main'], function() {
                    // Preload language contributions
                    require([
                        'vs/basic-languages/php/php.contribution',
                        'vs/basic-languages/sql/sql.contribution',
                        'vs/basic-languages/java/java.contribution',
                        'vs/basic-languages/python/python.contribution',
                        'vs/basic-languages/javascript/javascript.contribution',
                        'vs/basic-languages/html/html.contribution',
                        'vs/basic-languages/css/css.contribution'
                    ], function() {
                        console.log('Monaco language modules preloaded');
                    });
                });
            }
        </script>

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
            </flux:navlist.group>

            <!-- Academic Resources -->
            <flux:navlist.group heading="Academic Resources" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="academic-cap" :href="route('courses')" :current="request()->routeIs('courses')" wire:navigate class="py-1">{{ __('Courses') }}</flux:navlist.item>
                <flux:navlist.item icon="book-open" :href="route('learning-materials')" :current="request()->routeIs('learning-materials')" wire:navigate class="py-1">{{ __('Learning Materials') }}</flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('assignments')" :current="request()->routeIs('assignments')" wire:navigate class="py-1">{{ __('Challenges') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Student Management -->
            <flux:navlist.group heading="Student Management" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="user" :href="route('profile')" :current="request()->routeIs('profile')" wire:navigate class="py-1">{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item icon="calendar" :href="route('schedule')" :current="request()->routeIs('schedule')" wire:navigate class="py-1">{{ __('Schedule') }}</flux:navlist.item>
                <flux:navlist.item icon="chart-bar" :href="route('grades')" :current="request()->routeIs('dashboard')" wire:navigate class="py-1">{{ __('Grades') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Communication -->
            <flux:navlist.group heading="Communication" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="chat-bubble-left-right" :href="route('messages')" :current="request()->routeIs('messages')" wire:navigate class="py-1">{{ __('Messages') }}</flux:navlist.item>
            <flux:navlist.item icon="users" :href="route('forums')" :current="request()->routeIs('dashboard')" wire:navigate class="py-1">{{ __('Forums') }}</flux:navlist.item>
            </flux:navlist.group>

            <!-- Support & Help -->
            <flux:navlist.group heading="Support" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="question-mark-circle" :href="route('help-center')" :current="request()->routeIs('help-center')" wire:navigate class="py-1">{{ __('Help Center') }}</flux:navlist.item>
                <flux:navlist.item icon="lifebuoy" :href="route('technical-support')" :current="request()->routeIs('technical-support')" wire:navigate class="py-1">{{ __('Technical Support') }}</flux:navlist.item>
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
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />
                    
                    <!-- Gamification Statistics -->
                    <div class="px-2 py-2">
                        <div class="grid gap-2 rounded-lg bg-neutral-100 p-3 dark:bg-neutral-800">
                            <!-- Level and XP -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Level</span>
                                </div>
                                <span class="text-sm font-semibold">{{ auth()->user()->getLevel() ?? 1 }}</span>
                            </div>
                            
                            <!-- XP Progress Bar -->
                            <div>
                                <div class="mb-1 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">XP Progress</span>
                                    </div>
                                    @php
                                        $userAuth = auth()->user();
                                        $currentPoints = $userAuth ? ($userAuth->getPoints() ?? 0) : 0;
                                        $nextLevelAt = $userAuth ? ($userAuth->nextLevelAt() ?? 100) : 100;
                                        $previousLevelAt = 0; // This should be fetched from previous level if available
                                        
                                        // Avoid division by zero errors
                                        $denominator = ($nextLevelAt - $previousLevelAt);
                                        $progress = ($denominator > 0) ? (($currentPoints - $previousLevelAt) / $denominator * 100) : 0;
                                        
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
                                    <span class="text-xs font-medium">{{ $currentPoints }} / {{ $nextLevelAt }}</span>
                                </div>
                                
                                <div class="h-1.5 w-full rounded-full bg-neutral-200 dark:bg-neutral-700">
                                    <div class="h-1.5 rounded-full bg-emerald-500" style="width: {{ min(100, max(0, $progress)) }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Achievements & Badges -->
                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                    <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                        </svg>
                                        Achievements
                                    </div>
                                    <div class="text-sm font-bold">{{ auth()->user()->achievements()->count() }}</div>
                                </div>
                                <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                    <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Badges
                                    </div>
                                    <div class="text-sm font-bold">{{ auth()->user()->badges()->count() }}</div>
                                </div>
                            </div>
                            
                            <!-- Challenges -->
                            <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                    Active Challenges
                                </div>
                                <div class="text-sm font-bold">{{ auth()->user()->getActiveChallenges()->count() }}</div>
                            </div>
                            
                            <!-- Streak -->
                            @if(class_exists('\LevelUp\Experience\Models\Streak') && method_exists(auth()->user(), 'streak'))
                            <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                    Current Streak
                                </div>
                                <div class="text-sm font-bold">{{ auth()->user()->streak()->count() ?? 0 }} days</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                        <flux:menu.item href="/achievements" icon="trophy" wire:navigate>My Achievements</flux:menu.item>
                        <flux:menu.item href="/challenges" icon="fire" wire:navigate>Challenges</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
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
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />
                    
                    <!-- Gamification Statistics -->
                    <div class="px-2 py-2">
                        <div class="grid gap-2 rounded-lg bg-neutral-100 p-3 dark:bg-neutral-800">
                            <!-- Level and XP -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Level</span>
                                </div>
                                <span class="text-sm font-semibold">{{ auth()->user()->getLevel() ?? 1 }}</span>
                            </div>
                            
                            <!-- XP Progress Bar -->
                            <div>
                                <div class="mb-1 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">XP Progress</span>
                                    </div>
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
                                    <span class="text-xs font-medium">{{ $currentPoints }} / {{ $nextLevelAt }}</span>
                                </div>
                                
                                <div class="h-1.5 w-full rounded-full bg-neutral-200 dark:bg-neutral-700">
                                    <div class="h-1.5 rounded-full bg-emerald-500" style="width: {{ min(100, max(0, $progress)) }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Achievements & Badges -->
                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                    <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                        </svg>
                                        Achievements
                                    </div>
                                    <div class="text-sm font-bold">{{ auth()->user()->achievements()->count() }}</div>
                                </div>
                                <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                    <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Badges
                                    </div>
                                    <div class="text-sm font-bold">{{ auth()->user()->badges()->count() }}</div>
                                </div>
                            </div>
                            
                            <!-- Challenges -->
                            <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                    Active Challenges
                                </div>
                                <div class="text-sm font-bold">{{ auth()->user()->getActiveChallenges()->count() }}</div>
                            </div>
                            
                            <!-- Streak -->
                            @if(class_exists('\LevelUp\Experience\Models\Streak') && method_exists(auth()->user(), 'streak'))
                            <div class="rounded-md bg-neutral-200 p-2 text-center dark:bg-neutral-700">
                                <div class="flex items-center justify-center gap-1 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                    Current Streak
                                </div>
                                <div class="text-sm font-bold">{{ auth()->user()->streak()->count() ?? 0 }} days</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                        <flux:menu.item href="/achievements" icon="trophy" wire:navigate>My Achievements</flux:menu.item>
                        <flux:menu.item href="/challenges" icon="fire" wire:navigate>Challenges</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
