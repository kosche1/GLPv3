<x-layouts.app>
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <div class="mb-8">
            <a href="{{ route('study-groups.show', $studyGroup) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to {{ $studyGroup->name }}
            </a>
        </div>

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Group Discussions</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Collaborate and share ideas with your study group members</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('study-groups.discussions.create', $studyGroup) }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Discussion
                </a>
            </div>
        </div>

        @if($discussions->isEmpty())
            <div class="rounded-lg bg-white p-6 text-center shadow-md dark:bg-zinc-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                </svg>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No discussions yet</h3>
                <p class="text-gray-600 dark:text-gray-400">Be the first to start a discussion in this group!</p>
                <div class="mt-4">
                    <a href="{{ route('study-groups.discussions.create', $studyGroup) }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300">
                        Start a Discussion
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($discussions as $discussion)
                    <div class="rounded-lg bg-white p-5 shadow-sm transition-all hover:shadow-md dark:bg-zinc-800">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                    @if($discussion->user->avatar)
                                        <img src="{{ $discussion->user->avatar }}" alt="{{ $discussion->user->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-500">{{ $discussion->user->initials() }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <a href="{{ route('study-groups.discussions.show', [$studyGroup, $discussion]) }}" class="text-lg font-semibold text-gray-900 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-500">
                                            {{ $discussion->title }}
                                        </a>
                                        @if($discussion->is_pinned)
                                            <span class="ml-2 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/30 dark:text-amber-500">
                                                Pinned
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span>{{ $discussion->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $discussion->comments_count }} {{ Str::plural('comment', $discussion->comments_count) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($studyGroup->isModerator(auth()->user()) || $discussion->user_id === auth()->id())
                                <div class="flex space-x-2">
                                    @if($studyGroup->isModerator(auth()->user()))
                                        <form action="{{ route('study-groups.discussions.pin', [$studyGroup, $discussion]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-zinc-700 dark:hover:text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($discussion->user_id === auth()->id())
                                        <a href="{{ route('study-groups.discussions.edit', [$studyGroup, $discussion]) }}" class="rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-zinc-700 dark:hover:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-3 line-clamp-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ Str::limit(strip_tags($discussion->content), 150) }}
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('study-groups.discussions.show', [$studyGroup, $discussion]) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                                Read more
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-6">
                    {{ $discussions->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
