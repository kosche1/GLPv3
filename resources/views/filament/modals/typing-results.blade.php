<div class="p-6">
    <div class="mb-4">
        <h4 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h4>
        <p class="text-sm text-gray-600">Total Attempts: {{ $results->count() }}</p>
    </div>

    <div class="space-y-4 max-h-96 overflow-y-auto">
        @foreach($results as $result)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-4">
                        <div class="text-lg font-bold text-blue-600">
                            {{ $result->wpm }} WPM
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $result->accuracy }}% accuracy
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $result->created_at->format('M j, Y g:i A') }}
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($result->challenge_name)
                            Challenge: {{ $result->challenge_name }}
                        @else
                            Free Typing Mode
                        @endif
                    </div>
                    <div>
                        @if($result->approved)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                ✓ Approved
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                ⏳ Pending
                            </span>
                        @endif
                    </div>
                </div>

                @if($result->errors_count > 0)
                    <div class="mt-2 text-sm text-red-600">
                        Errors: {{ $result->errors_count }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
