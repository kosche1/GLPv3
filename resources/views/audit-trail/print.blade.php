<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail Record #{{ $record->id }} - Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background-color: #f5f5f5;
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .section-content {
            padding: 15px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .field-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .field-value {
            font-size: 16px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-registration {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-challenge {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-task {
            background-color: #fef3c7;
            color: #92400e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        table th {
            background-color: #f5f5f5;
            font-size: 12px;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Audit Trail Record #{{ $record->id }}</h1>
            <div>
                <button class="no-print" onclick="window.print()">Print</button>
                <button class="no-print" onclick="window.close()">Close</button>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Student Information</div>
            <div class="section-content grid">
                <div>
                    <div class="field-label">Student Name</div>
                    <div class="field-value">{{ $record->user->name }}</div>
                </div>

                <div>
                    <div class="field-label">Student Email</div>
                    <div class="field-value">{{ $record->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Activity Details</div>
            <div class="section-content grid">
                <div>
                    <div class="field-label">Action Type</div>
                    <div class="field-value">
                        @php
                            $actionType = match($record->action_type) {
                                'registration' => 'Registration',
                                'challenge_completion' => 'Challenge Completion',
                                'task_submission' => 'Task Submission',
                                default => $record->action_type,
                            };

                            $badgeClass = match($record->action_type) {
                                'registration' => 'badge-registration',
                                'challenge_completion' => 'badge-challenge',
                                'task_submission' => 'badge-task',
                                default => '',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $actionType }}</span>
                    </div>
                </div>

                <div>
                    <div class="field-label">Date & Time</div>
                    <div class="field-value">{{ $record->created_at->setTimezone(config('app.timezone'))->format('F j, Y g:i:s A') }}</div>
                </div>

                @if($record->subject_type)
                <div>
                    <div class="field-label">Subject Type</div>
                    <div class="field-value">{{ $record->subject_type }}</div>
                </div>
                @endif

                @if($record->subject_name)
                <div>
                    <div class="field-label">Subject Name</div>
                    <div class="field-value">{{ $record->subject_name }}</div>
                </div>
                @endif

                @if($record->challenge_name)
                <div>
                    <div class="field-label">Challenge</div>
                    <div class="field-value">{{ $record->challenge_name }}</div>
                </div>
                @endif

                @if($record->task_name)
                <div>
                    <div class="field-label">Task</div>
                    <div class="field-value">{{ $record->task_name }}</div>
                </div>
                @endif

                @if($record->score !== null)
                <div>
                    <div class="field-label">Score</div>
                    <div class="field-value">{{ $record->score }}</div>
                </div>
                @endif

                <div class="full-width">
                    <div class="field-label">Description</div>
                    <div class="field-value">{{ $record->description }}</div>
                </div>
            </div>
        </div>

        @if($record->additional_data)
        <div class="section">
            <div class="section-header">Additional Data</div>
            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($record->additional_data as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>
                                @if(is_array($value) || is_object($value))
                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
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
        @endif

        <div class="footer">
            GameLearnPro Audit Trail - Generated on {{ now()->setTimezone(config('app.timezone'))->format('F j, Y g:i:s A') }}
        </div>
    </div>

    <script>
        // Auto-print when the page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
