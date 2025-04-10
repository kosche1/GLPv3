<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Forums
                </h1>
                <div class="flex space-x-4">
                    <a href="{{ route('forum.create-topic') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        New Topic
                    </a>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 mb-4">
                <div class="relative w-full md:w-1/3">
                    <form action="{{ route('forum.search') }}" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="query" placeholder="Search forums..."
                            class="w-full rounded-md border border-neutral-700 bg-neutral-800 pl-8 pr-2 py-1 text-xs text-white placeholder-neutral-400 focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                    </form>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <a href="{{ route('forums') }}" class="px-2.5 py-0.5 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors">All</a>
                    @foreach($categories as $category)
                        <a href="{{ route('forum.category', $category->slug) }}" class="px-2.5 py-0.5 text-xs rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 transition-colors">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            <!-- Forum Categories -->
            <div class="space-y-3">
                @forelse($categories as $category)
                    <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-xs rounded-lg transition-all duration-300 ease-in-out hover:border-neutral-600">
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('forum.category', $category->slug) }}" class="text-base font-semibold text-white hover:text-emerald-400 transition-colors">{{ $category->name }}</a>
                                    <p class="text-neutral-400 mt-0.5 text-xs">{{ $category->description }}</p>
                                </div>
                                <div class="text-right text-xs text-neutral-400">
                                    <div>{{ $category->topics->count() }} topics</div>
                                    <div>{{ $category->topics->sum('comments_count') }} replies</div>
                                </div>
                            </div>

                            @if($category->topics->count() > 0)
                                <div class="mt-3 pt-3 border-t border-neutral-700">
                                    <div class="text-xs text-neutral-400 mb-1.5">Latest topics:</div>
                                    <div class="space-y-1.5">
                                        @foreach($category->topics()->latest()->take(3)->get() as $topic)
                                            <div class="flex justify-between items-center">
                                                <a href="{{ route('forum.topic', [$category->slug, $topic->slug]) }}" class="text-sm text-white hover:text-emerald-400 transition-colors truncate max-w-[70%]">{{ $topic->title }}</a>
                                                <div class="text-xs text-neutral-500">{{ $topic->created_at->diffForHumans() }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-neutral-800 border border-neutral-700 rounded-md p-4 text-center">
                        <p class="text-neutral-400 text-sm">No forum categories have been created yet.</p>
                        @if(Auth::user()->hasRole('admin'))
                            <p class="mt-1 text-neutral-400 text-xs">As an admin, you can create categories in the admin panel.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Trending Topics -->
            <div class="mt-4">
                <h2 class="text-base font-semibold text-white mb-3 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Trending Topics
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @forelse($trendingTopics as $topic)
                        <a href="{{ route('forum.topic', [$topic->category->slug, $topic->slug]) }}" class="p-3 rounded-lg border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-md">
                            <div class="flex justify-between items-start mb-1.5">
                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">{{ $topic->category->name }}</span>
                                <span class="text-xs text-neutral-400">{{ $topic->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-white text-sm font-medium mb-1">{{ $topic->title }}</h3>
                            <div class="text-neutral-400 text-xs mb-1.5 line-clamp-2">{{ Str::limit(strip_tags($topic->content), 80) }}</div>
                            <div class="flex justify-between items-center text-xs text-neutral-400">
                                <span class="truncate max-w-[60%]">By {{ $topic->user->name }}</span>
                                <span>{{ $topic->comments_count }} comments</span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 p-3 rounded-lg border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900">
                            <p class="text-center text-neutral-400 text-sm">No topics have been created yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
</x-layouts.app>