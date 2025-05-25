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
                            Score: {{ $result->score }}
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $result->recipe_name ?? 'Custom Recipe' }}
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $result->created_at->format('M j, Y g:i A') }}
                    </div>
                </div>
                
                <div class="flex items-center justify-between mb-2">
                    <div class="flex space-x-4 text-sm">
                        <span class="{{ $result->is_balanced ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result->is_balanced ? '✓ Balanced' : '✗ Unbalanced' }}
                        </span>
                        <span class="{{ $result->meets_requirements ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result->meets_requirements ? '✓ Requirements Met' : '✗ Requirements Not Met' }}
                        </span>
                    </div>
                    <div>
                        @if($result->points_awarded)
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

                @if($result->ingredients_used)
                    <div class="mt-3">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Ingredients Used:</h5>
                        <div class="text-xs text-gray-600 bg-white p-2 rounded border">
                            @php
                                $ingredients = is_string($result->ingredients_used) ? json_decode($result->ingredients_used, true) : $result->ingredients_used;
                            @endphp
                            @if(is_array($ingredients))
                                @foreach($ingredients as $ingredient)
                                    <div class="py-1">
                                        {{ is_array($ingredient) ? ($ingredient['name'] ?? 'Unknown') : $ingredient }}
                                        @if(is_array($ingredient) && isset($ingredient['amount']))
                                            - {{ $ingredient['amount'] }}
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <span>Ingredients data not available</span>
                            @endif
                        </div>
                    </div>
                @endif

                @if($result->feedback)
                    <div class="mt-2 text-sm text-gray-600">
                        <strong>Feedback:</strong> {{ $result->feedback }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
