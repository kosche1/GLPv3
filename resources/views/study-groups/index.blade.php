<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Study Groups</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Collaborate with other learners to achieve your goals together</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('study-groups.create') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Study Group
                </a>
            </div>
        </div>

        <!-- Join Private Group Form -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Join a Private Study Group</h2>
            <form action="{{ route('study-groups.join') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <div class="flex-grow">
                    <input type="text" name="join_code" placeholder="Enter join code" required
                        class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                </div>
                <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                    Join Group
                </button>
            </form>
        </div>

        <!-- My Study Groups -->
        <div class="mb-8">
            <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">My Study Groups</h2>
            
            @if($myGroups->isEmpty())
                <div class="rounded-lg bg-white p-6 text-center shadow-md dark:bg-zinc-800">
                    <p class="text-gray-600 dark:text-gray-400">You haven't joined any study groups yet.</p>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Create a new group or join an existing one to get started!</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($myGroups as $group)
                        <div class="group flex flex-col rounded-xl border border-neutral-200 bg-white overflow-hidden transition-all duration-300 hover:shadow-lg dark:border-neutral-700 dark:bg-zinc-800">
                            <!-- Group Image -->
                            <div class="h-40 w-full overflow-hidden bg-gradient-to-r from-emerald-500 to-blue-500">
                                @if($group->image)
                                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Group Info -->
                            <div class="flex flex-grow flex-col p-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $group->name }}</h3>
                                    <span class="rounded-full bg-{{ $group->is_private ? 'amber' : 'emerald' }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $group->is_private ? 'amber' : 'emerald' }}-800 dark:bg-{{ $group->is_private ? 'amber' : 'emerald' }}-900/30 dark:text-{{ $group->is_private ? 'amber' : 'emerald' }}-500">
                                        {{ $group->is_private ? 'Private' : 'Public' }}
                                    </span>
                                </div>
                                
                                <p class="mb-4 flex-grow text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::limit($group->description, 100) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="mb-3 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        {{ $group->members->count() }} / {{ $group->max_members }} members
                                    </div>
                                    
                                    <a href="{{ route('study-groups.show', $group) }}" class="inline-block w-full rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                                        View Group
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
            <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Public Study Groups</h2>
            
            @if($publicGroups->isEmpty())
                <div class="rounded-lg bg-white p-6 text-center shadow-md dark:bg-zinc-800">
                    <p class="text-gray-600 dark:text-gray-400">No public study groups available at the moment.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($publicGroups as $group)
                        <div class="group flex flex-col rounded-xl border border-neutral-200 bg-white overflow-hidden transition-all duration-300 hover:shadow-lg dark:border-neutral-700 dark:bg-zinc-800">
                            <!-- Group Image -->
                            <div class="h-40 w-full overflow-hidden bg-gradient-to-r from-blue-500 to-purple-500">
                                @if($group->image)
                                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Group Info -->
                            <div class="flex flex-grow flex-col p-4">
                                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">{{ $group->name }}</h3>
                                <p class="mb-4 flex-grow text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::limit($group->description, 100) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="mb-3 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        {{ $group->members_count }} / {{ $group->max_members }} members
                                    </div>
                                    
                                    <form action="{{ route('study-groups.join') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="study_group_id" value="{{ $group->id }}">
                                        <button type="submit" class="inline-block w-full rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                                            Join Group
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
