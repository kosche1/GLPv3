<x-filament-panels::page>
    <div class="flex flex-col gap-y-8 print:p-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Audit Trail Record #{{ $record->id }}</h1>
            
            <button 
                type="button"
                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 print:hidden"
                onclick="window.print()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -ml-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
        </div>
        
        <div class="print:text-right text-sm text-gray-500 print:mb-4">
            <span>Generated on: {{ now()->format('F j, Y g:i A') }}</span>
        </div>
        
        <div class="border rounded-xl overflow-hidden">
            <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Student Information</h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Name</h3>
                    <p class="mt-1 text-lg">{{ $record->user->name }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Email</h3>
                    <p class="mt-1 text-lg">{{ $record->user->email }}</p>
                </div>
            </div>
        </div>
        
        <div class="border rounded-xl overflow-hidden">
            <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Activity Details</h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Action Type</h3>
                    <p class="mt-1 text-lg">
                        @php
                            $actionType = match($record->action_type) {
                                'registration' => 'Registration',
                                'challenge_completion' => 'Challenge Completion',
                                'task_submission' => 'Task Submission',
                                default => $record->action_type,
                            };
                            
                            $actionColor = match($record->action_type) {
                                'registration' => 'bg-green-100 text-green-800',
                                'challenge_completion' => 'bg-blue-100 text-blue-800',
                                'task_submission' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $actionColor }}">
                            {{ $actionType }}
                        </span>
                    </p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date & Time</h3>
                    <p class="mt-1 text-lg">{{ $record->created_at->format('F j, Y g:i A') }}</p>
                </div>
                
                @if($record->subject_type)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject Type</h3>
                    <p class="mt-1 text-lg">{{ $record->subject_type }}</p>
                </div>
                @endif
                
                @if($record->subject_name)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject Name</h3>
                    <p class="mt-1 text-lg">{{ $record->subject_name }}</p>
                </div>
                @endif
                
                @if($record->challenge_name)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Challenge</h3>
                    <p class="mt-1 text-lg">{{ $record->challenge_name }}</p>
                </div>
                @endif
                
                @if($record->task_name)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Task</h3>
                    <p class="mt-1 text-lg">{{ $record->task_name }}</p>
                </div>
                @endif
                
                @if($record->score !== null)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Score</h3>
                    <p class="mt-1 text-lg">{{ $record->score }}</p>
                </div>
                @endif
                
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
                    <p class="mt-1 text-lg">{{ $record->description }}</p>
                </div>
            </div>
        </div>
        
        @if($record->additional_data)
        <div class="border rounded-xl overflow-hidden">
            <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Additional Data</h2>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Key</th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach($record->additional_data as $key => $value)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $key }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if(is_array($value) || is_object($value))
                                        <pre class="text-xs">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <div class="print:fixed print:bottom-0 print:left-0 print:w-full print:text-center print:py-4 print:text-sm print:text-gray-500 print:border-t">
            <p>GameLearnPro Audit Trail - Generated on {{ now()->format('F j, Y g:i A') }}</p>
        </div>
    </div>
    
    <style>
        @media print {
            /* Hide unnecessary elements when printing */
            .fi-topbar,
            .fi-sidebar,
            .fi-header-heading button,
            .fi-tabs nav,
            .fi-footer,
            .print\:hidden {
                display: none !important;
            }
            
            /* Ensure the content takes up the full page */
            .fi-main {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }
            
            /* Make text darker for better printing */
            body {
                color: #000 !important;
                background: #fff !important;
            }
            
            /* Ensure all content is visible */
            .fi-section {
                page-break-inside: avoid;
                margin-bottom: 20px !important;
            }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-print when the page loads
            if (window.location.href.includes('/print')) {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        });
    </script>
</x-filament-panels::page>
