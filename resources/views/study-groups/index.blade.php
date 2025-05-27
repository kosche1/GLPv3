<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="mb-12">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-blue-500 to-purple-600 p-8 text-white">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <h1 class="text-4xl font-bold mb-3">Study Groups</h1>
                            <p class="text-lg text-white/90 max-w-2xl">Join collaborative learning communities and achieve your academic goals together with fellow students</p>

                            <!-- Quick Stats -->
                            <div class="mt-6 flex flex-wrap gap-6">
                                <div class="flex items-center space-x-2">
                                    <div class="rounded-full bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/80">Your Groups</p>
                                        <p class="font-semibold">{{ $myGroups->count() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="rounded-full bg-white/20 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/80">Available</p>
                                        <p class="font-semibold">{{ $publicGroups->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('study-groups.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-lg transition-all duration-200 hover:bg-gray-50 hover:shadow-xl hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 transition-transform group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Create Study Group
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-6 -left-6 h-32 w-32 rounded-full bg-white/5"></div>
            </div>
        </div>

        <!-- Enhanced Join Private Group Form -->
        <div class="mb-8">
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-lg ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-zinc-700">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/10 dark:to-blue-900/10"></div>
                <div class="relative z-10">
                    <div class="mb-4 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-emerald-500 to-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Join a Private Study Group</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enter the invitation code shared by the group creator</p>
                    </div>

                    <form action="{{ route('study-groups.join') }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="relative">
                            <label for="join_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invitation Code</label>
                            <div class="relative">
                                <input type="text"
                                       id="join_code"
                                       name="join_code"
                                       placeholder="Enter 8-character code (e.g., ABC12345)"
                                       required
                                       maxlength="8"
                                       class="w-full rounded-lg border-2 border-gray-200 bg-gray-50 px-3 py-2.5 text-center text-base font-mono tracking-wider text-gray-900 transition-all duration-200 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:bg-zinc-600">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="group w-full rounded-lg bg-gradient-to-r from-emerald-600 to-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:from-emerald-700 hover:to-blue-700 hover:shadow-lg hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                            <span class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 transition-transform group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                </svg>
                                Join Study Group
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- My Study Groups -->
        <div class="mb-12">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">My Study Groups</h2>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Groups you've joined or created</p>
                </div>
                @if(!$myGroups->isEmpty())
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $myGroups->count() }} {{ Str::plural('group', $myGroups->count()) }}
                    </div>
                @endif
            </div>

            @if($myGroups->isEmpty())
                <div class="relative overflow-hidden rounded-xl bg-white p-8 text-center shadow-md ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-zinc-700">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-zinc-800 dark:to-zinc-900"></div>
                    <div class="relative z-10">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-r from-gray-200 to-gray-300 dark:from-zinc-700 dark:to-zinc-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Study Groups Yet</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto">You haven't joined any study groups yet. Start your collaborative learning journey today!</p>
                        <div class="flex flex-col sm:flex-row gap-2 justify-center">
                            <a href="{{ route('study-groups.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-md transition-all duration-200 hover:bg-emerald-700 hover:shadow-lg hover:scale-[1.02]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Create Your First Group
                            </a>
                            <button onclick="document.getElementById('join_code').focus()" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 hover:border-gray-400 hover:bg-gray-50 dark:border-zinc-600 dark:bg-zinc-800 dark:text-gray-300 dark:hover:border-zinc-500 dark:hover:bg-zinc-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                                </svg>
                                Join with Code
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($myGroups as $group)
                        <div class="group relative flex flex-col overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-md transition-all duration-300 hover:shadow-lg hover:scale-[1.01] hover:-translate-y-0.5 dark:border-neutral-700 dark:bg-zinc-800">
                            <!-- Group Image -->
                            <div class="relative h-36 w-full overflow-hidden bg-gradient-to-br from-emerald-500 via-blue-500 to-purple-500">
                                @if($group->image)
                                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white/80 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                @endif
                                <!-- Overlay gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

                                <!-- Privacy Badge -->
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $group->is_private ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' }} backdrop-blur-sm">
                                        @if($group->is_private)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                            </svg>
                                            Private
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                            </svg>
                                            Public
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Group Info -->
                            <div class="flex flex-grow flex-col p-4">
                                <div class="mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $group->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ Str::limit($group->description, 80) }}
                                    </p>
                                </div>

                                <!-- Group Stats -->
                                <div class="mb-3 flex items-center justify-between text-sm">
                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        <span class="font-medium">{{ $group->members->count() }}</span>
                                        <span class="mx-1 text-gray-400">/</span>
                                        <span>{{ $group->max_members }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $group->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        <span>Capacity</span>
                                        <span>{{ round(($group->members->count() / $group->max_members) * 100) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-zinc-700">
                                        <div class="bg-gradient-to-r from-emerald-500 to-blue-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ ($group->members->count() / $group->max_members) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    <a href="{{ route('study-groups.show', $group) }}" class="group/btn inline-flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-emerald-600 to-blue-600 px-3 py-2 text-sm font-medium text-white shadow-md transition-all duration-200 hover:from-emerald-700 hover:to-blue-700 hover:shadow-lg hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                        <span>View Group</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-3.5 w-3.5 transition-transform group-hover/btn:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Public Study Groups -->
        <div>
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Discover Public Groups</h2>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Join open communities and expand your learning network</p>
                </div>
                @if(!$publicGroups->isEmpty())
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $publicGroups->count() }} available {{ Str::plural('group', $publicGroups->count()) }}
                    </div>
                @endif
            </div>

            @if($publicGroups->isEmpty())
                <div class="relative overflow-hidden rounded-xl bg-white p-8 text-center shadow-md ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-zinc-700">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/10 dark:to-purple-900/10"></div>
                    <div class="relative z-10">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-r from-blue-200 to-purple-300 dark:from-blue-700 dark:to-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Public Groups Available</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto">There are no public study groups available right now. Be the first to create one!</p>
                        <a href="{{ route('study-groups.create') }}" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-2 text-sm font-medium text-white shadow-md transition-all duration-200 hover:from-blue-700 hover:to-purple-700 hover:shadow-lg hover:scale-[1.02]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create First Public Group
                        </a>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($publicGroups as $group)
                        <div class="group relative flex flex-col overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-md transition-all duration-300 hover:shadow-lg hover:scale-[1.01] hover:-translate-y-0.5 dark:border-neutral-700 dark:bg-zinc-800">
                            <!-- Group Image -->
                            <div class="relative h-36 w-full overflow-hidden bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                @if($group->image)
                                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white/80 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                @endif
                                <!-- Overlay gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

                                <!-- Public Badge -->
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                        </svg>
                                        Public
                                    </span>
                                </div>

                                <!-- Join Indicator -->
                                <div class="absolute top-3 left-3">
                                    <div class="rounded-full bg-white/20 p-1.5 backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Group Info -->
                            <div class="flex flex-grow flex-col p-4">
                                <div class="mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $group->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ Str::limit($group->description, 80) }}
                                    </p>
                                </div>

                                <!-- Group Stats -->
                                <div class="mb-3 flex items-center justify-between text-sm">
                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        <span class="font-medium">{{ $group->members_count ?? 0 }}</span>
                                        <span class="mx-1 text-gray-400">/</span>
                                        <span>{{ $group->max_members }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $group->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        <span>Available Spots</span>
                                        <span>{{ round((($group->members_count ?? 0) / $group->max_members) * 100) }}% filled</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-zinc-700">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ (($group->members_count ?? 0) / $group->max_members) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Join Button -->
                                <div class="mt-auto">
                                    @if(($group->members_count ?? 0) >= $group->max_members)
                                        <div class="w-full rounded-lg bg-gray-100 px-3 py-2 text-center text-sm font-medium text-gray-500 dark:bg-zinc-700 dark:text-gray-400">
                                            Group Full
                                        </div>
                                    @else
                                        <form action="{{ route('study-groups.join') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="study_group_id" value="{{ $group->id }}">
                                            <button type="submit" class="group/btn inline-flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 px-3 py-2 text-sm font-medium text-white shadow-md transition-all duration-200 hover:from-blue-700 hover:to-purple-700 hover:shadow-lg hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-3.5 w-3.5 transition-transform group-hover/btn:scale-110" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                                </svg>
                                                <span>Join Group</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-3.5 w-3.5 transition-transform group-hover/btn:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
