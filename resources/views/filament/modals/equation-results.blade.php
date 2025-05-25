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
                        <div class="text-lg font-bold text-green-600">
                            Score: {{ $result->score }}
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $result->accuracy_percentage }}% accuracy
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $result->created_at->format('M j, Y g:i A') }}
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Time: {{ $result->time_taken }}s
                    </div>
                    <div>
                        @if($result->completed)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                ✓ Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                ✗ Incomplete
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                    <div class="text-gray-600">
                        Correct: {{ $result->correct_answers }}
                    </div>
                    <div class="text-gray-600">
                        Wrong: {{ $result->wrong_answers }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
