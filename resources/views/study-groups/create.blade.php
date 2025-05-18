<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Study Groups
            </a>
        </div>

        <div class="mx-auto max-w-3xl">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create a New Study Group</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Form a collaborative learning community with other students</p>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <form action="{{ route('study-groups.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Group Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="image" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Group Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload an image for your study group (optional, max 2MB)</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="max_members" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Maximum Members <span class="text-red-500">*</span></label>
                            <input type="number" id="max_members" name="max_members" value="{{ old('max_members', 10) }}" min="2" max="50" required
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-emerald-500 dark:focus:ring-emerald-500">
                            @error('max_members')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Privacy Setting</label>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_private" name="is_private" value="1" {{ old('is_private') ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-emerald-600 focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-emerald-600">
                                <label for="is_private" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Make this group private</label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Private groups require a join code to access</p>
                            @error('is_private')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Focus Areas</label>
                        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="checkbox" id="category_{{ $category->id }}" name="focus_areas[]" value="{{ $category->id }}" 
                                        {{ in_array($category->id, old('focus_areas', [])) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-emerald-600 focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-emerald-600">
                                    <label for="category_{{ $category->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select the main focus areas for your study group</p>
                        @error('focus_areas')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                            Create Study Group
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
