<x-layouts.app>
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Attendance Test</h1>
            </div>
        </div>

        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-6 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h2 class="text-xl font-bold text-white">Test Results</h2>
            </div>

            <div id="results" class="text-white">
                <p>Loading test results...</p>
            </div>

            <div class="mt-6">
                <button id="runTest" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                    Run Test
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resultsDiv = document.getElementById('results');
            const runTestButton = document.getElementById('runTest');

            runTestButton.addEventListener('click', function() {
                resultsDiv.innerHTML = '<p>Running test...</p>';

                fetch('{{ route("test.attendance") }}')
                    .then(response => response.json())
                    .then(data => {
                        let html = '<div class="space-y-4">';

                        if (data.error) {
                            html += `<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                                <h3 class="text-lg font-semibold text-red-400">Error</h3>
                                <p class="text-white">${data.error}</p>
                                ${data.trace ? `<pre class="mt-2 p-2 bg-neutral-900 rounded text-xs overflow-x-auto">${data.trace}</pre>` : ''}
                            </div>`;
                        } else {
                            html += `<div class="p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
                                <h3 class="text-lg font-semibold text-emerald-400">Success</h3>
                                <p class="text-white">${data.message}</p>
                            </div>`;

                            html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-neutral-800 rounded-lg">
                                    <h4 class="font-medium text-neutral-400 mb-2">DB Insert Result</h4>
                                    <p class="text-lg font-semibold">${data.db_insert_result ? 'Success' : 'Failed'}</p>
                                </div>

                                <div class="p-4 bg-neutral-800 rounded-lg">
                                    <h4 class="font-medium text-neutral-400 mb-2">Model Result</h4>
                                    <p class="text-lg font-semibold">${data.model_result ? 'Success' : 'Failed'}</p>
                                </div>
                            </div>`;

                            if (data.record) {
                                html += `<div class="p-4 bg-blue-500/20 border border-blue-500/30 rounded-lg">
                                    <h3 class="text-lg font-semibold text-blue-400">Existing Record</h3>
                                    <pre class="mt-2 p-2 bg-neutral-900 rounded text-xs overflow-x-auto">${JSON.stringify(data.record, null, 2)}</pre>
                                </div>`;
                            }
                        }

                        html += '</div>';
                        resultsDiv.innerHTML = html;
                    })
                    .catch(error => {
                        resultsDiv.innerHTML = `<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-400">Error</h3>
                            <p class="text-white">${error.message}</p>
                        </div>`;
                    });
            });

            // Run the test automatically on page load
            runTestButton.click();
        });
    </script>
</x-layouts.app>
