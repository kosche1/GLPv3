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
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-zinc-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-zinc-300 md:ml-2">Frequently Asked Questions</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Header Section with Animated Gradient -->
            <div class="text-center mb-12 relative">
                <div class="absolute inset-0 bg-linear-to-r from-blue-500/10 via-purple-500/10 to-emerald-500/10 rounded-xl blur-xl opacity-50"></div>
                <div class="relative">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Frequently Asked Questions</h1>
                    <p class="text-lg text-zinc-300 max-w-3xl mx-auto">Find quick answers to the most common questions about our platform</p>
                </div>
            </div>

            <!-- Search Section -->
            <div class="mb-12">
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('help-center.search') }}" method="GET" class="relative">
                        <input type="text" name="query" placeholder="Search in FAQs..." class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800/80 text-white placeholder-neutral-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 hover:border-neutral-600 transition-all duration-300 ease-in-out pl-12">
                        <div class="absolute left-3 top-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute right-3 top-2 px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-sm border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- FAQs by Category -->
            @foreach($categories as $category)
                @if($category->faqs->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-{{ $category->color ?? 'emerald' }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $category->name }}
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($category->faqs as $index => $faq)
                        <!-- FAQ Item -->
                        <div class="border border-neutral-700 rounded-lg overflow-hidden">
                            <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq-{{ $category->id }}-{{ $index }}')">
                                <span class="font-medium text-white">{{ $faq->question }}</span>
                                <svg id="faq-{{ $category->id }}-{{ $index }}-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $category->color ?? 'emerald' }}-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="faq-{{ $category->id }}-{{ $index }}" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                                <p class="text-zinc-300 text-sm">
                                    {{ $faq->answer }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

            @if($categories->sum(function($category) { return $category->faqs->count(); }) == 0)
            <div class="p-8 rounded-xl border border-neutral-700 bg-neutral-800/50 text-center">
                <p class="text-zinc-400">No FAQs available yet. Check back soon!</p>
            </div>
            @endif

            <!-- Back to Help Center -->
            <div class="text-center mb-8">
                <a href="{{ route('help-center') }}" class="inline-flex items-center text-emerald-400 hover:text-emerald-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Back to Help Center
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript for FAQ Accordion -->
    <script>
        function toggleFaq(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</x-layouts.app>
