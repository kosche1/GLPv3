<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('forums') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <a href="{{ route('forum.category', $category->slug) }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                {{ $category->name }}
            </a>
            <span class="text-neutral-500">/</span>
            <span class="text-white truncate">{{ $topic->title }}</span>
        </div>

        <div class="mt-6 space-y-4">
            <!-- Forum Post -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-xs rounded-xl transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <!-- Post Header -->
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="h-10 w-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-medium">
                            {{ $topic->user->initials() }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Posted by {{ $topic->user->name }}</p>
                            <p class="text-xs text-neutral-400">{{ $topic->created_at->diffForHumans() }}</p>
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <h2 class="text-xl font-semibold text-white mb-2">{{ $topic->title }}</h2>
                    <div class="text-neutral-300 mb-4 prose prose-invert max-w-none">
                        {!! $topic->content !!}
                    </div>

                    <!-- Post Actions -->
                    <div class="flex items-center space-x-4 text-sm text-neutral-400">
                        <div class="flex items-center space-x-2">
                            <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                    data-likeable-id="{{ $topic->id }}"
                                    data-likeable-type="topic"
                                    data-is-like="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                            <span class="likes-count">{{ $topic->likes_count }}</span>
                            <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                    data-likeable-id="{{ $topic->id }}"
                                    data-likeable-type="topic"
                                    data-is-like="false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>{{ $topic->comments_count }} Comments</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ $topic->views_count }} Views</span>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="border-t border-neutral-700">
                    <div class="p-6 space-y-6">
                        <!-- Comment Input -->
                        <div class="flex space-x-4">
                            <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">
                                {{ Auth::user()->initials() }}
                            </div>
                            <div class="flex-1">
                                <form action="{{ route('forum.store-comment', $topic->id) }}" method="POST">
                                    @csrf
                                    <textarea name="content" class="w-full px-3 py-2 text-sm text-white bg-neutral-800 border border-neutral-700 rounded-lg focus:outline-hidden focus:border-indigo-500 focus:ring-3 focus:ring-indigo-500/20 transition-all duration-300" rows="3" placeholder="What are your thoughts?"></textarea>
                                    <button type="submit" class="mt-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-600/20">Comment</button>
                                </form>
                            </div>
                        </div>

                        <!-- Comment Thread -->
                        <div class="space-y-4">
                            @forelse($topic->comments as $comment)
                                <!-- Parent Comment -->
                                <div class="flex space-x-4">
                                    <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">
                                        {{ $comment->user->initials() }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-4 hover:border-neutral-600 transition-all duration-300">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <span class="font-medium text-white">{{ $comment->user->name }}</span>
                                                <span class="text-xs text-neutral-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-neutral-300">{{ $comment->content }}</p>
                                            <div class="mt-2 flex items-center space-x-4 text-sm text-neutral-400">
                                                <div class="flex items-center space-x-2">
                                                    <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                                            data-likeable-id="{{ $comment->id }}"
                                                            data-likeable-type="comment"
                                                            data-is-like="true">↑</button>
                                                    <span class="likes-count">{{ $comment->likes_count }}</span>
                                                    <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                                            data-likeable-id="{{ $comment->id }}"
                                                            data-likeable-type="comment"
                                                            data-is-like="false">↓</button>
                                                </div>
                                                <button class="reply-button hover:text-emerald-400 transition-colors duration-300" data-comment-id="{{ $comment->id }}">Reply</button>
                                            </div>

                                            <!-- Reply Form (hidden by default) -->
                                            <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                                                <form action="{{ route('forum.store-comment', $topic->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <textarea name="content" class="w-full px-3 py-2 text-sm text-white bg-neutral-800 border border-neutral-700 rounded-lg focus:outline-hidden focus:border-indigo-500 focus:ring-3 focus:ring-indigo-500/20 transition-all duration-300" rows="2" placeholder="Write your reply..."></textarea>
                                                    <div class="mt-2 flex justify-end space-x-2">
                                                        <button type="button" class="cancel-reply px-3 py-1 text-sm text-neutral-400 hover:text-white transition-colors" data-comment-id="{{ $comment->id }}">Cancel</button>
                                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02]">Reply</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Nested Comments -->
                                        @if($comment->replies->count() > 0)
                                            @foreach($comment->replies as $reply)
                                                <div class="mt-4 ml-8">
                                                    <div class="flex space-x-4">
                                                        <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">
                                                            {{ $reply->user->initials() }}
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-4 hover:border-neutral-600 transition-all duration-300">
                                                                <div class="flex items-center space-x-2 mb-2">
                                                                    <span class="font-medium text-white">{{ $reply->user->name }}</span>
                                                                    <span class="text-xs text-neutral-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-neutral-300">{{ $reply->content }}</p>
                                                                <div class="mt-2 flex items-center space-x-4 text-sm text-neutral-400">
                                                                    <div class="flex items-center space-x-2">
                                                                        <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                                                                data-likeable-id="{{ $reply->id }}"
                                                                                data-likeable-type="comment"
                                                                                data-is-like="true">↑</button>
                                                                        <span class="likes-count">{{ $reply->likes_count }}</span>
                                                                        <button class="like-button hover:text-emerald-400 transition-colors duration-300"
                                                                                data-likeable-id="{{ $reply->id }}"
                                                                                data-likeable-type="comment"
                                                                                data-is-like="false">↓</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-neutral-400">
                                    <p>No comments yet. Be the first to comment!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reply functionality
            document.querySelectorAll('.reply-button').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
                });
            });

            document.querySelectorAll('.cancel-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
                });
            });

            // Like functionality
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', function() {
                    const likeableId = this.getAttribute('data-likeable-id');
                    const likeableType = this.getAttribute('data-likeable-type');
                    const isLike = this.getAttribute('data-is-like') === 'true';

                    fetch('{{ route('forum.like') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            likeable_id: likeableId,
                            likeable_type: likeableType,
                            is_like: isLike
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update the likes count
                        const likesCountElement = this.closest('.flex').querySelector('.likes-count');
                        likesCountElement.textContent = data.likes_count;

                        // Highlight the button if liked/disliked
                        if (data.action === 'liked') {
                            this.classList.add('text-emerald-400');
                        } else if (data.action === 'disliked') {
                            this.classList.add('text-red-400');
                        } else {
                            this.classList.remove('text-emerald-400', 'text-red-400');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</x-layouts.app>
