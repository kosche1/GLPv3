<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">{{ $challenge->name }} - Task {{ $currentTask }}</h1>
            <div class="flex gap-4">
                <a href="{{ route('challenge', $challenge) }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back to Challenge</span>
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <!-- Task Details -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <h2 class="text-lg font-semibold text-white mb-4">Task Details</h2>
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">Task {{ $currentTask }} of {{ $totalTasks }}</span>
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $taskPoints }} Points</span>
                        </div>
                        <p class="text-neutral-400">{{ $task->description }}</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Requirements</h3>
                        <ul class="list-disc list-inside space-y-2 text-neutral-400">
                            @foreach($task->requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Hints</h3>
                        <div class="p-4 rounded-lg bg-emerald-500/5 border border-emerald-500/20">
                            <p class="text-sm text-emerald-400">{{ $task->hint }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Code Editor -->
            <div class="md:col-span-2 flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-white">Code Editor</h2>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-lg hover:bg-emerald-500/20 transition-colors duration-300">Run Tests</button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition-colors duration-300">Submit Solution</button>
                    </div>
                </div>
                <div class="flex-1 min-h-[400px] rounded-lg bg-neutral-900 border border-neutral-700">
                    <!-- Code editor component will be rendered here -->
                    <div class="h-full w-full p-4">
                        <textarea class="w-full h-full bg-transparent text-neutral-300 font-mono text-sm focus:outline-none" placeholder="Write your code here..."></textarea>
                    </div>
                </div>
                <!-- Test Results -->
                <div class="mt-4 p-4 rounded-lg bg-neutral-900 border border-neutral-700">
                    <h3 class="text-sm font-semibold text-white mb-2">Test Results</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                            <span class="text-neutral-400">All test cases passed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>