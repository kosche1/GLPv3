<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('goals.index') }}" class="text-neutral-400 hover:text-white transition-colors duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Goals
            </a>
        </div>

        <div class="bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Edit Goal</h1>

            <form action="{{ route('goals.update', $goal) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-neutral-300 mb-1">Goal Title</label>
                    <input type="text" name="title" id="title" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('title', $goal->title) }}" required>
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-neutral-300 mb-1">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Describe your goal...">{{ old('description', $goal->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="target_value" class="block text-sm font-medium text-neutral-300 mb-1">Target Value</label>
                    <input type="number" name="target_value" id="target_value" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('target_value', $goal->target_value) }}" min="1" required>
                    @error('target_value')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded bg-neutral-900 border-neutral-700 text-emerald-500 focus:ring-emerald-500" {{ $goal->is_active ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-neutral-300">Active</span>
                    </label>
                    <p class="text-xs text-neutral-400 mt-1">Inactive goals will not be displayed on your dashboard.</p>
                </div>

                <div class="mb-6">
                    <div class="text-sm text-neutral-400 bg-neutral-900/50 rounded-lg p-4 border border-neutral-700/50">
                        <p class="font-medium text-neutral-300 mb-1">Goal Type: {{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}</p>
                        <p class="mb-2">Time Period: {{ ucfirst($goal->period_type) }}</p>

                        @if($goal->start_date)
                            <p>
                                Date Range: {{ $goal->start_date->format('M j, Y') }}
                                @if($goal->end_date)
                                    - {{ $goal->end_date->format('M j, Y') }}
                                @endif
                            </p>
                        @endif

                        <p class="mt-2 text-xs text-neutral-500">Note: Goal type, time period, and date range cannot be changed after creation.</p>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('goals.index') }}" class="px-6 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200">
                        Update Goal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>
