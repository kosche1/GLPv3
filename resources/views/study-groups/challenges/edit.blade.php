<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.challenges.show', [$studyGroup, $groupChallenge]) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Challenge
            </a>
        </div>

        <div class="mx-auto max-w-3xl">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Group Challenge</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Update the challenge for {{ $studyGroup->name }}</p>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <form action="{{ route('study-groups.challenges.update', [$studyGroup, $groupChallenge]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Challenge Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $groupChallenge->name) }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">{{ old('description', $groupChallenge->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select id="category_id" name="category_id"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $groupChallenge->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="difficulty_level" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Difficulty Level</label>
                            <select id="difficulty_level" name="difficulty_level"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                                <option value="">Select difficulty</option>
                                <option value="beginner" {{ old('difficulty_level', $groupChallenge->difficulty_level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('difficulty_level', $groupChallenge->difficulty_level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('difficulty_level', $groupChallenge->difficulty_level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="expert" {{ old('difficulty_level', $groupChallenge->difficulty_level) === 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                            @error('difficulty_level')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                            <input type="datetime-local" id="start_date" name="start_date" 
                                value="{{ old('start_date', $groupChallenge->start_date ? $groupChallenge->start_date->format('Y-m-d\TH:i') : '') }}"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                            <input type="datetime-local" id="end_date" name="end_date" 
                                value="{{ old('end_date', $groupChallenge->end_date ? $groupChallenge->end_date->format('Y-m-d\TH:i') : '') }}"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="points_reward" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Points Reward</label>
                            <input type="number" id="points_reward" name="points_reward" value="{{ old('points_reward', $groupChallenge->points_reward) }}" min="0"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('points_reward')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time_limit" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Time Limit (minutes)</label>
                            <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit', $groupChallenge->time_limit) }}" min="0"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('time_limit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="challenge_content" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Challenge Content</label>
                        <textarea id="challenge_content" name="challenge_content" rows="6"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500"
                            placeholder="Provide detailed instructions, requirements, and any additional information for the challenge...">{{ old('challenge_content', $groupChallenge->challenge_content) }}</textarea>
                        @error('challenge_content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="completion_criteria" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Completion Criteria</label>
                        <textarea id="completion_criteria" name="completion_criteria" rows="3"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500"
                            placeholder="Define what participants need to do to complete this challenge...">{{ old('completion_criteria', $groupChallenge->completion_criteria) }}</textarea>
                        @error('completion_criteria')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $groupChallenge->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-emerald-600 focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-emerald-600">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Challenge is active</label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Only active challenges can be joined by participants</p>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('study-groups.challenges.show', [$studyGroup, $groupChallenge]) }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                            Update Challenge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
