<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.discussions.index', $studyGroup) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Discussions
            </a>
        </div>

        <!-- Discussion Header -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
            <div class="flex items-start justify-between">
                <div class="flex-grow">
                    <div class="flex items-center gap-2 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $discussion->title }}</h1>
                        @if($discussion->is_pinned)
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                Pinned
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center">
                            <div class="h-8 w-8 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                @if($discussion->user->avatar)
                                    <img src="{{ $discussion->user->avatar }}" alt="{{ $discussion->user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-500">{{ $discussion->user->initials() }}</span>
                                    </div>
                                @endif
                            </div>
                            <span class="ml-2">{{ $discussion->user->name }}</span>
                        </div>
                        <span class="mx-2">•</span>
                        <span>{{ $discussion->created_at->diffForHumans() }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $discussion->comments->count() }} {{ Str::plural('comment', $discussion->comments->count()) }}</span>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    @if($userRole === 'leader' || $userRole === 'moderator')
                        <form action="{{ route('study-groups.discussions.pin', [$studyGroup, $discussion]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                {{ $discussion->is_pinned ? 'Unpin' : 'Pin' }}
                            </button>
                        </form>
                    @endif
                    
                    @if($discussion->user_id === auth()->id() || $userRole === 'leader' || $userRole === 'moderator')
                        <a href="{{ route('study-groups.discussions.edit', [$studyGroup, $discussion]) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <div class="prose max-w-none dark:prose-invert">
                    {!! nl2br(e($discussion->content)) !!}
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mb-8">
            <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Comments</h2>
            
            <!-- Add Comment Form -->
            <div class="mb-6 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <form action="{{ route('study-groups.discussions.comment', [$studyGroup, $discussion]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Add a comment</label>
                        <textarea id="content" name="content" rows="3" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500"
                            placeholder="Share your thoughts..."></textarea>
                    </div>
                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                        Post Comment
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            @if($discussion->rootComments->count() > 0)
                <div class="space-y-6">
                    @foreach($discussion->rootComments as $comment)
                        <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                            <div class="flex items-start">
                                <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                    @if($comment->user->avatar)
                                        <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-500">{{ $comment->user->initials() }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-grow">
                                    <div class="flex items-center">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</h4>
                                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-2 text-gray-700 dark:text-gray-300">
                                        {!! nl2br(e($comment->content)) !!}
                                    </div>
                                    
                                    <!-- Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-4 space-y-4 border-l-2 border-gray-200 pl-4 dark:border-gray-600">
                                            @foreach($comment->replies as $reply)
                                                <div class="flex items-start">
                                                    <div class="h-8 w-8 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                                        @if($reply->user->avatar)
                                                            <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="h-full w-full object-cover">
                                                        @else
                                                            <div class="flex h-full w-full items-center justify-center">
                                                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-500">{{ $reply->user->initials() }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-3 flex-grow">
                                                        <div class="flex items-center">
                                                            <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $reply->user->name }}</h5>
                                                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                                            {!! nl2br(e($reply->content)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-lg bg-white p-6 text-center shadow-md dark:bg-zinc-800">
                    <p class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
