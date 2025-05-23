<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.show', $studyGroup) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to {{ $studyGroup->name }}
            </a>
        </div>

        <div class="mx-auto max-w-3xl">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create a Group Challenge</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Create a collaborative challenge for your study group members</p>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <form action="{{ route('study-groups.challenges.store', $studyGroup) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Challenge Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="4" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                            <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                            <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="points_reward" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Points Reward <span class="text-red-500">*</span></label>
                            <input type="number" id="points_reward" name="points_reward" value="{{ old('points_reward', 100) }}" min="0" required
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('points_reward')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="difficulty_level" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Difficulty Level <span class="text-red-500">*</span></label>
                            <select id="difficulty_level" name="difficulty_level" required
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                                <option value="1" {{ old('difficulty_level') == 1 ? 'selected' : '' }}>Beginner</option>
                                <option value="2" {{ old('difficulty_level') == 2 ? 'selected' : '' }}>Easy</option>
                                <option value="3" {{ old('difficulty_level') == 3 ? 'selected' : '' }}>Intermediate</option>
                                <option value="4" {{ old('difficulty_level') == 4 ? 'selected' : '' }}>Advanced</option>
                                <option value="5" {{ old('difficulty_level') == 5 ? 'selected' : '' }}>Expert</option>
                            </select>
                            @error('difficulty_level')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="category_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category_id" name="category_id"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="challenge_type" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Challenge Type</label>
                        <select id="challenge_type" name="challenge_type"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            <option value="">Select a type</option>
                            <option value="quiz" {{ old('challenge_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                            <option value="project" {{ old('challenge_type') == 'project' ? 'selected' : '' }}>Project</option>
                            <option value="discussion" {{ old('challenge_type') == 'discussion' ? 'selected' : '' }}>Discussion</option>
                            <option value="research" {{ old('challenge_type') == 'research' ? 'selected' : '' }}>Research</option>
                            <option value="presentation" {{ old('challenge_type') == 'presentation' ? 'selected' : '' }}>Presentation</option>
                        </select>
                        @error('challenge_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="challenge_content" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Challenge Content</label>
                        <textarea id="challenge_content" name="challenge_content" rows="6"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">{{ old('challenge_content') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Provide detailed instructions, requirements, or questions for the challenge.</p>
                        @error('challenge_content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                            Create Challenge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
