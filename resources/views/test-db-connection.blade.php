<x-layouts.app>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Database Connection Test</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Connection Status</h2>

            @php
            $connectionStatus = 'Unknown';
            $error = null;

            try {
                // Test database connection
                DB::connection()->getPdo();
                $connectionStatus = 'Connected';

                // Get database name
                $dbName = DB::connection()->getDatabaseName();
            } catch (\Exception $e) {
                $connectionStatus = 'Failed';
                $error = $e->getMessage();
            }
            @endphp

            <div class="mb-6">
                <p class="mb-2">
                    <span class="font-medium">Status:</span>
                    @if($connectionStatus == 'Connected')
                        <span class="text-green-600 font-semibold">{{ $connectionStatus }}</span>
                    @else
                        <span class="text-red-600 font-semibold">{{ $connectionStatus }}</span>
                    @endif
                </p>

                @if($connectionStatus == 'Connected')
                    <p class="mb-2"><span class="font-medium">Database:</span> {{ $dbName }}</p>
                @endif

                @if($error)
                    <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                        <p class="font-medium">Error:</p>
                        <p class="font-mono text-sm">{{ $error }}</p>
                    </div>
                @endif
            </div>

            <h2 class="text-xl font-semibold mb-4">StudentAnswer Table Test</h2>

            <div class="mb-4">
                <a href="{{ route('fix.student-answers-table') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Fix Student Answers Table
                </a>
                <span class="ml-2 text-sm text-gray-500">Click this button if you see errors with the student_answers table</span>
            </div>

            @php
            $tableStatus = 'Unknown';
            $tableError = null;
            $columns = [];
            $recentAnswers = [];

            try {
                // Check if the table exists
                if(Schema::hasTable('student_answers')) {
                    $tableStatus = 'Exists';

                    // Get column information using SQLite-compatible syntax
                    $columns = DB::select("PRAGMA table_info(student_answers)");

                    // Get recent answers
                    $recentAnswers = DB::table('student_answers')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                } else {
                    $tableStatus = 'Missing';
                }
            } catch (\Exception $e) {
                $tableStatus = 'Error';
                $tableError = $e->getMessage();
            }
            @endphp

            <div class="mb-6">
                <p class="mb-2">
                    <span class="font-medium">Table Status:</span>
                    @if($tableStatus == 'Exists')
                        <span class="text-green-600 font-semibold">{{ $tableStatus }}</span>
                    @elseif($tableStatus == 'Missing')
                        <span class="text-yellow-600 font-semibold">{{ $tableStatus }}</span>
                    @else
                        <span class="text-red-600 font-semibold">{{ $tableStatus }}</span>
                    @endif
                </p>

                @if($tableError)
                    <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                        <p class="font-medium">Error:</p>
                        <p class="font-mono text-sm">{{ $tableError }}</p>
                    </div>
                @endif

                @if(count($columns) > 0)
                    <div class="mt-4">
                        <h3 class="text-lg font-medium mb-2">Table Columns</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">CID</th>
                                        <th class="py-2 px-4 border-b">Name</th>
                                        <th class="py-2 px-4 border-b">Type</th>
                                        <th class="py-2 px-4 border-b">Not Null</th>
                                        <th class="py-2 px-4 border-b">Default</th>
                                        <th class="py-2 px-4 border-b">Primary Key</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($columns as $column)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $column->cid }}</td>
                                        <td class="py-2 px-4 border-b">{{ $column->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $column->type }}</td>
                                        <td class="py-2 px-4 border-b">{{ $column->notnull ? 'YES' : 'NO' }}</td>
                                        <td class="py-2 px-4 border-b">{{ $column->dflt_value }}</td>
                                        <td class="py-2 px-4 border-b">{{ $column->pk ? 'YES' : 'NO' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if(count($recentAnswers) > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium mb-2">Recent Student Answers</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">ID</th>
                                        <th class="py-2 px-4 border-b">User ID</th>
                                        <th class="py-2 px-4 border-b">Task ID</th>
                                        <th class="py-2 px-4 border-b">Status</th>
                                        <th class="py-2 px-4 border-b">Is Correct</th>
                                        <th class="py-2 px-4 border-b">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAnswers as $answer)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $answer->id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $answer->user_id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $answer->task_id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $answer->status }}</td>
                                        <td class="py-2 px-4 border-b">{{ $answer->is_correct ? 'Yes' : 'No' }}</td>
                                        <td class="py-2 px-4 border-b">{{ $answer->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p class="mt-4 text-yellow-600">No student answers found in the database.</p>
                @endif
            </div>

            <h2 class="text-xl font-semibold mb-4">Test StudentAnswer Creation</h2>

            <form method="POST" action="{{ route('test.create-student-answer') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                    <input type="number" name="user_id" id="user_id" value="{{ auth()->id() }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="task_id" class="block text-sm font-medium text-gray-700">Task ID</label>
                    <input type="number" name="task_id" id="task_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="submitted_text" class="block text-sm font-medium text-gray-700">Submitted Text</label>
                    <textarea name="submitted_text" id="submitted_text" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>

                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Test Answer
                    </button>
                </div>
            </form>

            @if(session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
