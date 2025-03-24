<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">Learning Portal</h1>
            <div class="flex gap-4">
                <a href="{{ route ('dashboard') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back</span>
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Course Cards -->
            @foreach($challenges as $challenge)
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-4">
                    <div class="h-40 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden">
                        @if($challenge->image)
                            <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full">
                        @else
                            <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $challenge->name }}</h3>
                        <p class="mt-2 text-sm text-neutral-400">{{ $challenge->description }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-emerald-400">{{ $challenge->difficulty_level }}</span>
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300">Start →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Learning Path Progress -->
        <div class="mt-8 p-6 rounded-xl border border-neutral-700 bg-neutral-800">
            <h2 class="text-lg font-semibold text-white mb-4">Your Learning Path</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full {{ $progress > 0 ? 'bg-emerald-400' : 'bg-neutral-700' }}"></div>
                    <div class="flex-1">
                        <div class="h-2 rounded-full bg-neutral-700">
                            <div class="h-2 rounded-full bg-emerald-400" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-emerald-400">{{ $progress }}%</span>
                </div>
                <div class="grid grid-cols-4 gap-4 text-sm">
                    @php
                        $levels = ['Beginner', 'Intermediate', 'Advanced', 'Expert'];
                        $currentLevel = $completedLevels + 1;
                    @endphp

                    @foreach($levels as $index => $level)
                        <div class="text-center">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-full {{ $index + 1 <= $completedLevels ? 'bg-emerald-500/10' : 'bg-neutral-700' }} flex items-center justify-center">
                                <span class="{{ $index + 1 <= $completedLevels ? 'text-emerald-400' : 'text-neutral-400' }}">{{ $index + 1 }}</span>
                            </div>
                            <span class="text-neutral-400">{{ $level }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>