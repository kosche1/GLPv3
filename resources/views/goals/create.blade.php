<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('goals.index') }}" class="text-neutral-400 hover:text-white transition-colors duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Goals
            </a>
            <a href="{{ route('dashboard') }}" class="text-neutral-400 hover:text-white transition-colors duration-200 flex items-center gap-2">
                Back to Dashboard
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>
        </div>

        <div class="bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Create New Goal</h1>

            <form action="{{ route('goals.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-neutral-300 mb-1">Goal Title</label>
                    <input type="text" name="title" id="title" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., Complete 10 coding challenges" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-neutral-300 mb-1">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Describe your goal...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="goal_type" class="block text-sm font-medium text-neutral-300 mb-1">Goal Type</label>
                        <select name="goal_type" id="goal_type" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                            <option value="">Select a goal type</option>
                            <option value="login_streak" {{ old('goal_type') == 'login_streak' ? 'selected' : '' }}>Login Streak</option>
                            <option value="daily_activity" {{ old('goal_type') == 'daily_activity' ? 'selected' : '' }}>Daily Activity</option>
                            <option value="weekly_activity" {{ old('goal_type') == 'weekly_activity' ? 'selected' : '' }}>Weekly Activity</option>
                            <option value="tasks_completed" {{ old('goal_type') == 'tasks_completed' ? 'selected' : '' }}>Tasks Completed</option>
                            <option value="challenges_completed" {{ old('goal_type') == 'challenges_completed' ? 'selected' : '' }}>Challenges Completed</option>
                            <option value="experience_points" {{ old('goal_type') == 'experience_points' ? 'selected' : '' }}>Experience Points</option>
                        </select>
                        @error('goal_type')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="target_value" class="block text-sm font-medium text-neutral-300 mb-1">Target Value</label>
                        <input type="number" name="target_value" id="target_value" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., 10" value="{{ old('target_value') }}" min="1" required>
                        @error('target_value')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="period_type" class="block text-sm font-medium text-neutral-300 mb-1">Time Period</label>
                    <select name="period_type" id="period_type" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                        <option value="all_time" {{ old('period_type') == 'all_time' ? 'selected' : '' }}>All Time</option>
                        <option value="daily" {{ old('period_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('period_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('period_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="custom" {{ old('period_type') == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                    </select>
                    @error('period_type')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="custom_dates" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6" style="display: none;">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-neutral-300 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-neutral-300 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <div id="goal_type_description" class="text-sm text-neutral-400 bg-neutral-900/50 rounded-lg p-4 border border-neutral-700/50">
                        Select a goal type to see its description.
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200">
                        Create Goal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const goalTypeSelect = document.getElementById('goal_type');
        const goalTypeDescription = document.getElementById('goal_type_description');
        const periodTypeSelect = document.getElementById('period_type');
        const customDatesDiv = document.getElementById('custom_dates');

        // Goal type descriptions
        const descriptions = {
            'login_streak': 'Maintain a consecutive login streak by logging in every day.',
            'daily_activity': 'Complete a certain number of activities in a single day.',
            'weekly_activity': 'Complete a certain number of activities within a week.',
            'tasks_completed': 'Complete a specific number of tasks.',
            'challenges_completed': 'Complete a specific number of challenges.',
            'experience_points': 'Earn a specific amount of experience points.'
        };

        // Update description when goal type changes
        goalTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            if (selectedType && descriptions[selectedType]) {
                goalTypeDescription.textContent = descriptions[selectedType];
            } else {
                goalTypeDescription.textContent = 'Select a goal type to see its description.';
            }
        });

        // Show/hide custom date fields based on period type
        periodTypeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDatesDiv.style.display = 'grid';
            } else {
                customDatesDiv.style.display = 'none';
            }
        });

        // Initialize with current values
        if (goalTypeSelect.value) {
            const event = new Event('change');
            goalTypeSelect.dispatchEvent(event);
        }

        if (periodTypeSelect.value === 'custom') {
            customDatesDiv.style.display = 'grid';
        }
    });
</script>
</x-layouts.app>
