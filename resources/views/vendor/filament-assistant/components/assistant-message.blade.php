<div class="flex items-start mb-4">
    <!-- Assistant avatar can be added here -->
    <div class="mr-2">
        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
            <span class="text-primary-500">AI</span>
        </div>
    </div>
    <!-- Assistant message bubble -->
    <div class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-3 rounded-lg shadow-md max-w-xl">
        @if(isset($message['name']))<div class="font-semibold mb-1 text-primary-500">{{$message['name'] ?? ''}}</div>@endif
        <div>
            {!! \Illuminate\Support\Str::markdown($message['content']) !!}
        </div>
    </div>
</div> 