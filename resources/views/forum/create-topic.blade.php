<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('forums') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            @if(isset($category))
                <a href="{{ route('forum.category', $category->slug) }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                    {{ $category->name }}
                </a>
                <span class="text-neutral-500">/</span>
            @endif
            <span class="text-white">Create New Topic</span>
        </div>
        
        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-xs rounded-xl p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Create a New Topic</h2>
            
            <form action="{{ route('forum.store-topic') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="forum_category_id" class="block text-sm font-medium text-neutral-300 mb-2">Category</label>
                    <select id="forum_category_id" name="forum_category_id" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ isset($category) && $category->id === $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('forum_category_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-neutral-300 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" placeholder="Enter a descriptive title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-neutral-300 mb-2">Content</label>
                    <textarea id="content" name="content" rows="8" class="w-full rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600" placeholder="Write your topic content here...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <a href="{{ isset($category) ? route('forum.category', $category->slug) : route('forums') }}" class="mr-4 px-4 py-2 text-sm text-neutral-400 hover:text-white transition-colors">Cancel</a>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-600/20">Create Topic</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
