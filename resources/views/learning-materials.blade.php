<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-white">{{ __('Learning Materials') }}</h1>
            
            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search materials..." class="w-64 rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                </div>
                <select class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                    <option value="all">All Materials</option>
                    <option value="pdf">PDF</option>
                    <option value="video">Video</option>
                    <option value="document">Document</option>
                </select>
            </div>
        </div>
        <br>
        <!-- Learning Materials Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Material Card -->
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-neutral-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700">
                <div class="mb-4 flex items-center justify-between">
                    <span class="rounded-full bg-emerald-900 px-3 py-1 text-xs font-medium text-emerald-200">{{ ['PDF', 'Video', 'Document'][$i-1] }}</span>
                    <span class="text-sm text-neutral-400">Module {{ $i }}</span>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-white">Learning Material {{ $i }}</h3>
                <p class="mb-4 text-sm text-neutral-400">Essential study materials for this module. Includes comprehensive guides and reference materials.</p>
                <div class="mb-4 flex items-center space-x-2 text-sm text-neutral-400">
                    <span>{{ ['2.5 MB', '15 MB', '1.8 MB'][$i-1] }}</span>
                    <span>•</span>
                    <span>Last updated: {{ date('M d, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <button class="inline-flex items-center space-x-1 text-sm text-blue-400 hover:text-blue-300 transition-colors duration-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Preview</span>
                        </button>
                    </div>
                    <a href="#" class="inline-flex items-center space-x-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-neutral-800 transition-colors duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Download</span>
                    </a>
                </div>
            </div>
            @endfor
        </div>
        <br>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-center">
            <nav class="flex space-x-2" aria-label="Pagination">
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-colors duration-300">Previous</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-white hover:bg-neutral-700 transition-colors duration-300">1</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-colors duration-300">2</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-colors duration-300">3</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 transition-colors duration-300">Next</a>
            </nav>
        </div>
    </div>
</x-layouts.app>