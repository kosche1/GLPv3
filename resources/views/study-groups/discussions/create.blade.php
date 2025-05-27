<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.discussions.index', $studyGroup) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Discussions
            </a>
        </div>

        <div class="mx-auto max-w-3xl">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Start a New Discussion</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Create a discussion topic for {{ $studyGroup->name }}</p>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <form action="{{ route('study-groups.discussions.store', $studyGroup) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="title" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Discussion Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500"
                            placeholder="Enter a descriptive title for your discussion">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="content" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Discussion Content <span class="text-red-500">*</span></label>
                        <textarea id="content" name="content" rows="8" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500"
                            placeholder="Share your thoughts, ask questions, or start a conversation...">{{ old('content') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Be clear and descriptive to encourage meaningful discussions</p>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('study-groups.discussions.index', $studyGroup) }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                            Start Discussion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
