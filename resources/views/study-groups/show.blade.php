<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Study Groups
            </a>
        </div>

        <!-- Group Header -->
        <div class="relative mb-8 overflow-hidden rounded-xl bg-white shadow-md dark:bg-zinc-800">
            <!-- Cover Image -->
            <div class="h-48 w-full bg-gradient-to-r from-emerald-500 to-blue-500 sm:h-64">
                @if($studyGroup->image)
                    <img src="{{ asset('storage/' . $studyGroup->image) }}" alt="{{ $studyGroup->name }}" class="h-full w-full object-cover">
                @endif
            </div>
            
            <!-- Group Info -->
            <div class="p-6">
                <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex items-center">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $studyGroup->name }}</h1>
                            <span class="ml-3 rounded-full bg-{{ $studyGroup->is_private ? 'amber' : 'emerald' }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $studyGroup->is_private ? 'amber' : 'emerald' }}-800 dark:bg-{{ $studyGroup->is_private ? 'amber' : 'emerald' }}-900/30 dark:text-{{ $studyGroup->is_private ? 'amber' : 'emerald' }}-500">
                                {{ $studyGroup->is_private ? 'Private' : 'Public' }}
                            </span>
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Created by {{ $studyGroup->creator->name }} on {{ $studyGroup->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @if($studyGroup->isLeader(auth()->user()))
                            <a href="{{ route('study-groups.edit', $studyGroup) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit Group
                            </a>
                        @endif
                        
                        @if($studyGroup->hasMember(auth()->user()))
                            <form action="{{ route('study-groups.leave', $studyGroup) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-200 dark:border-red-600 dark:bg-zinc-800 dark:text-red-500 dark:hover:border-red-600 dark:hover:bg-red-700/20 dark:hover:text-red-400 dark:focus:ring-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5-5H3zm6.293 11.293a1 1 0 001.414 1.414l4-4a1 1 0 000-1.414l-4-4a1 1 0 00-1.414 1.414L11.586 9H7a1 1 0 100 2h4.586l-2.293 2.293z" clip-rule="evenodd" />
                                    </svg>
                                    Leave Group
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                
                @if($studyGroup->description)
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">About this group</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $studyGroup->description }}</p>
                    </div>
                @endif
                
                @if($studyGroup->is_private && $studyGroup->isLeader(auth()->user()))
                    <div class="mt-4 rounded-lg bg-blue-50 p-4 dark:bg-blue-900/30">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-1l1-1 1-1-.257-.257A6 6 0 1118 8zm-6-4a1 1 0 100 2h2a1 1 0 100-2h-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-400">Group Join Code</h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <p>Share this code with others to invite them to your private group:</p>
                                    <div class="mt-1 flex items-center">
                                        <code class="rounded bg-blue-100 px-2 py-1 font-mono text-blue-800 dark:bg-blue-800/50 dark:text-blue-200">{{ $studyGroup->join_code }}</code>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $studyGroup->join_code }}')" class="ml-2 rounded-lg p-1 text-blue-600 hover:bg-blue-200 dark:text-blue-400 dark:hover:bg-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Group Navigation -->
        <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="mr-2">
                    <a href="#members" class="inline-flex items-center justify-center p-4 text-emerald-600 border-b-2 border-emerald-600 rounded-t-lg active dark:text-emerald-500 dark:border-emerald-500 group" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-emerald-600 dark:text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        Members
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('study-groups.challenges.create', $studyGroup) }}" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                        </svg>
                        Challenges
                    </a>
                </li>
                <li class="mr-2">
                    <a href="{{ route('study-groups.discussions.index', $studyGroup) }}" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                        </svg>
                        Discussions
                    </a>
                </li>
            </ul>
        </div>

        <!-- Members Section -->
        <div id="members" class="mb-8">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Members ({{ $studyGroup->members->count() }}/{{ $studyGroup->max_members }})</h2>
            </div>
            
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($studyGroup->members as $member)
                    <div class="flex items-center rounded-lg bg-white p-4 shadow-sm dark:bg-zinc-800">
                        <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                            @if($member->avatar)
                                <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-500">{{ $member->initials() }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                                <span class="ml-2 rounded-full bg-{{ $member->pivot->role === 'leader' ? 'purple' : ($member->pivot->role === 'moderator' ? 'blue' : 'gray') }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $member->pivot->role === 'leader' ? 'purple' : ($member->pivot->role === 'moderator' ? 'blue' : 'gray') }}-800 dark:bg-{{ $member->pivot->role === 'leader' ? 'purple' : ($member->pivot->role === 'moderator' ? 'blue' : 'gray') }}-900/30 dark:text-{{ $member->pivot->role === 'leader' ? 'purple' : ($member->pivot->role === 'moderator' ? 'blue' : 'gray') }}-500">
                                    {{ ucfirst($member->pivot->role) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Joined {{ \Carbon\Carbon::parse($member->pivot->joined_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
