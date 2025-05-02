<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Specialized Subjects</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('learning') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to Learning Portal</span>
                </a>
            </div>
        </div>

        <!-- Description Section -->
        <div class="p-4 bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-shrink-0">
                    <h2 class="text-lg font-semibold text-white">About Specialized Subjects</h2>
                    <p class="text-sm text-neutral-300">
                        Advanced disciplines focusing on cutting-edge fields and technologies.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 md:ml-auto">
                    @foreach($strands as $strand)
                    <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium text-emerald-400">{{ $strand->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Specialized Tracks Section -->
        <div class="mt-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white">Specialized Tracks</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-3 lg:grid-cols-5">
                @foreach($strands as $strand)
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg" style="color: {{ $strand->color ?? '#10B981' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $strand->name }}</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">{{ $strand->description }}</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ in_array($strand->code, ['abm', 'he', 'humms', 'stem', 'ict']) ? route('subjects.specialized.' . $strand->code) : route('subjects.specialized.strand', $strand->code) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore {{ $strand->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>
    </div>
</x-layouts.app>
