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
            </flux:navlist.group>
            
            <!-- Academic Resources -->
            <flux:navlist.group heading="Academic Resources" class="grid gap-1" expandable :expanded="true" icon="chevron-down" class-icon="ml-auto h-4 w-4 shrink-0 transition-transform duration-200">
                <flux:navlist.item icon="academic-cap" :href="route('courses')" :current="request()->routeIs('courses')" wire:navigate class="py-1">{{ __('Courses') }}</flux:navlist.item>
                <flux:navlist.item icon="book-open" :href="route('learning-materials')" :current="request()->routeIs('learning-materials')" wire:navigate class="py-1">{{ __('Learning Materials') }}</flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('assignments')" :current="request()->routeIs('assignments')" wire:navigate class="py-1">{{ __('Assignments') }}</flux:navlist.item>
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

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
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

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
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
