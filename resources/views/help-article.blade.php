<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Breadcrumb Navigation -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('help-center') }}" class="inline-flex items-center text-sm font-medium text-zinc-400 hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Help Center
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-zinc-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('help-center.category', $category) }}" class="ml-1 text-sm font-medium text-zinc-400 hover:text-white md:ml-2">{{ $category->name }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-zinc-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-zinc-300 md:ml-2">{{ $article->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Article Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="md:col-span-3">
                    <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800/50">
                        <h1 class="text-3xl font-bold text-white mb-4">{{ $article->title }}</h1>
                        
                        <div class="flex items-center text-sm text-zinc-400 mb-6">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $article->created_at->format('M d, Y') }}
                            </span>
                            <span class="mx-3">•</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $article->views_count }} views
                            </span>
                        </div>
                        
                        <div class="prose prose-invert max-w-none">
                            {!! $article->content !!}
                        </div>
                    </div>

                    <!-- Was this helpful? -->
                    <div class="mt-8 p-6 rounded-xl border border-neutral-700 bg-neutral-800/50 text-center">
                        <h3 class="text-lg font-semibold text-white mb-4">Was this article helpful?</h3>
                        <div class="flex justify-center space-x-4">
                            <button class="px-4 py-2 bg-emerald-500/20 text-emerald-400 rounded-md border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                Yes
                            </button>
                            <button class="px-4 py-2 bg-red-500/20 text-red-400 rounded-md border border-red-500/30 hover:bg-red-500/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2" />
                                </svg>
                                No
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="md:col-span-1">
                    <!-- Related Articles -->
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-3">Related Articles</h3>
                        @if($relatedArticles->count() > 0)
                        <ul class="space-y-3">
                            @foreach($relatedArticles as $relatedArticle)
                            <li>
                                <a href="{{ route('help-center.article', ['category' => $category, 'article' => $relatedArticle]) }}" class="text-zinc-300 hover:text-{{ $category->color ?? 'emerald' }}-400 transition-colors text-sm flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0 text-{{ $category->color ?? 'emerald' }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>{{ $relatedArticle->title }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-zinc-400 text-sm">No related articles available.</p>
                        @endif
                    </div>

                    <!-- Category Articles -->
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50">
                        <h3 class="text-lg font-semibold text-white mb-3">More in {{ $category->name }}</h3>
                        <a href="{{ route('help-center.category', $category) }}" class="text-{{ $category->color ?? 'emerald' }}-400 hover:text-{{ $category->color ?? 'emerald' }}-300 transition-colors text-sm flex items-center">
                            <span>View all articles</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back to Category -->
            <div class="text-center mt-8 mb-8">
                <a href="{{ route('help-center.category', $category) }}" class="inline-flex items-center text-{{ $category->color ?? 'emerald' }}-400 hover:text-{{ $category->color ?? 'emerald' }}-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Back to {{ $category->name }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
