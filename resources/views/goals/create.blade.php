<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('goals.index') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <a href="{{ route('goals.index') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                Goals
            </a>
            <span class="text-neutral-500">/</span>
            <span class="text-white">Create New Goal</span>
        </div>

        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-xs rounded-xl p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Create a New Goal</h2>

            <form action="{{ route('goals.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-neutral-300 mb-2">Goal Title</label>
                    <input type="text" name="title" id="title" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" placeholder="e.g., Complete 10 coding challenges" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-neutral-300 mb-2">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" placeholder="Describe your goal...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="goal_type" class="block text-sm font-medium text-neutral-300 mb-2">Goal Type</label>
                        <select name="goal_type" id="goal_type" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" required>
                            <option value="">Select a goal type</option>
                            <option value="login_streak" {{ old('goal_type') == 'login_streak' ? 'selected' : '' }}>Login Streak</option>
                            <option value="daily_activity" {{ old('goal_type') == 'daily_activity' ? 'selected' : '' }}>Daily Activity</option>
                            <option value="weekly_activity" {{ old('goal_type') == 'weekly_activity' ? 'selected' : '' }}>Weekly Activity</option>
                            <option value="tasks_completed" {{ old('goal_type') == 'tasks_completed' ? 'selected' : '' }}>Tasks Completed</option>
                            <option value="challenges_completed" {{ old('goal_type') == 'challenges_completed' ? 'selected' : '' }}>Challenges Completed</option>
                            <option value="experience_points" {{ old('goal_type') == 'experience_points' ? 'selected' : '' }}>Experience Points</option>
                        </select>
                        @error('goal_type')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="target_value" class="block text-sm font-medium text-neutral-300 mb-2">Target Value</label>
                        <input type="number" name="target_value" id="target_value" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" placeholder="e.g., 10" value="{{ old('target_value') }}" min="1" required>
                        @error('target_value')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="period_type" class="block text-sm font-medium text-neutral-300 mb-2">Time Period</label>
                    <select name="period_type" id="period_type" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" required>
                        <option value="all_time" {{ old('period_type') == 'all_time' ? 'selected' : '' }}>All Time</option>
                        <option value="daily" {{ old('period_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('period_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('period_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="custom" {{ old('period_type') == 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                    </select>
                    @error('period_type')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div id="custom_dates" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6" style="display: none;">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-neutral-300 mb-2">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-neutral-300 mb-2">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <div id="goal_type_description" class="text-sm text-neutral-400 bg-neutral-800 rounded-lg p-4 border border-neutral-700/50">
                        Select a goal type to see its description.
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('goals.index') }}" class="mr-4 px-4 py-2 text-sm text-neutral-400 hover:text-white transition-colors">Cancel</a>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-600/20">
                        Create Goal
                    </button>
                </div>
            </form>
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
