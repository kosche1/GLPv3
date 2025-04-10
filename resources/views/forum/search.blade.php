<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('forums') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                        Search Results
                    </h1>
                </div>
                <p class="text-neutral-400">Showing results for: "{{ $query }}"</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('forum.create-topic') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New Topic
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="relative w-full md:w-1/2">
                <form action="{{ route('forum.search') }}" method="GET">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="query" value="{{ $query }}" placeholder="Search topics..."
                        class="w-full rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                </form>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            @if($topics->isEmpty())
                <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-8 text-center">
                    <p class="text-neutral-400">No topics found matching your search.</p>
                    <a href="{{ route('forum.create-topic') }}" class="mt-4 inline-block bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02]">
                        Create a new topic
                    </a>
                </div>
            @else
                @foreach($topics as $topic)
                    <div class="bg-linear-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-xs rounded-xl transition-all duration-300 ease-in-out hover:border-neutral-600">
                        <div class="p-6">
                            <!-- Topic Header -->
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="h-10 w-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-medium">
                                    {{ $topic->user->initials() }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">Posted by {{ $topic->user->name }}</p>
                                    <p class="text-xs text-neutral-400">{{ $topic->created_at->diffForHumans() }}</p>
                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        {{ $topic->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Topic Content -->
                            <a href="{{ route('forum.topic', [$topic->category->slug, $topic->slug]) }}" class="block">
                                <h2 class="text-xl font-semibold text-white mb-2 hover:text-emerald-400 transition-colors">{{ $topic->title }}</h2>
                                <div class="text-neutral-300 mb-4 line-clamp-2">{{ Str::limit(strip_tags($topic->content), 150) }}</div>
                            </a>

                            <!-- Topic Actions -->
                            <div class="flex items-center space-x-4 text-sm text-neutral-400">
                                <div class="flex items-center space-x-2">
                                    <span>{{ $topic->likes_count }}</span>
                                    <span>likes</span>
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
                    </div>
                @endforeach

                <div class="mt-6">
                    {{ $topics->appends(['query' => $query])->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
