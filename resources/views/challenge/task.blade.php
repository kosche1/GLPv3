<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">{{ $challenge->name }} - {{ $currentTask->name }}</h1>
            <div class="flex gap-4">
                <a href="{{ route('challenge', $challenge) }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back to Challenge</span>
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <!-- Task Content -->
            <div class="md:col-span-2 flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $currentTask->points_reward ?? 0 }} Points</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Scenario</h4>
                            <p>{{ $challenge->challenge_content['scenario'] ?? 'No scenario available' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Code with Bugs</h4>
                            <pre class="p-4 rounded-lg bg-neutral-900 text-neutral-300 font-mono text-sm whitespace-pre overflow-x-auto">{{ $challenge->challenge_content['buggy_code'] ?? 'No code available' }}</pre>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Current Behavior</h4>
                            <p>{{ $challenge->challenge_content['current_behavior'] ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Expected Behavior</h4>
                            
                            <p>{{ $currentTask->description }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Task Instructions</h3>
                        <div class="prose prose-invert max-w-none">
                            <div class="space-y-4">
                                <div class="p-4 rounded-lg bg-neutral-700/50">
                                    <h4 class="text-emerald-400 font-medium mb-2">Debug Process</h4>
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>Review the code and identify the issue</li>
                                        <li>Test the code with different inputs</li>
                                        <li>Fix the bug with minimal changes</li>
                                        <li>Verify the solution works</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Code Editor -->
            <div class="flex flex-col h-[600px] p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <h2 class="text-lg font-semibold text-white mb-4">Your Solution</h2>
                <div class="flex-1 min-h-0">
                    <code-editor
                        :initial-code="{{ json_encode($challenge->challenge_content['buggy_code'] ?? '') }}"
                        :challenge-id="{{ json_encode($challenge->id) }}"
                        :task-id="{{ json_encode($currentTask->id) }}"
                    />
                </div>
            </div>

            <!-- Task Navigation -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <h2 class="text-lg font-semibold text-white mb-4">Task Navigation</h2>
                <div class="space-y-4">
                    @if($nextTask)
                        <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) }}" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center">
                            Next Task
                        </a>
                    @else
                        <div class="w-full py-3 px-4 rounded-xl bg-neutral-700 text-neutral-400 font-semibold text-center cursor-not-allowed">
                            Last Task
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>