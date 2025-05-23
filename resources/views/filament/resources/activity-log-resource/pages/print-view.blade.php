<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audit Trail Record #{{ $record->id }}</title>
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
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin-top: 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            padding-left: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media print {
            body {
                padding: 0;
            }
            .print-button {
                display: none;
            }
        }
        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .print-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="print-button" onclick="window.print()">Print This Page</button>
        
        <div class="header">
            <h1>Audit Trail Record #{{ $record->id }}</h1>
            <p>Generated on: {{ now()->format('F j, Y, g:i a') }}</p>
        </div>
        
        <div class="section">
            <div class="section-title">Basic Information</div>
            <div class="field">
                <div class="field-label">Subject Type:</div>
                <div class="field-value">{{ $record->log_name }}</div>
            </div>
            <div class="field">
                <div class="field-label">Description:</div>
                <div class="field-value">{{ $record->description }}</div>
            </div>
            <div class="field">
                <div class="field-label">Action:</div>
                <div class="field-value">{{ ucfirst($record->event) }}</div>
            </div>
            <div class="field">
                <div class="field-label">Created At:</div>
                <div class="field-value">{{ $record->created_at->format('F j, Y, g:i a') }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">User Information</div>
            <div class="field">
                <div class="field-label">User Type:</div>
                <div class="field-value">{{ $record->causer_type ? class_basename($record->causer_type) : 'System' }}</div>
            </div>
            <div class="field">
                <div class="field-label">User ID:</div>
                <div class="field-value">{{ $record->causer_id ?? 'N/A' }}</div>
            </div>
            <div class="field">
                <div class="field-label">User Details:</div>
                <div class="field-value">
                    @if (!$record->causer)
                        System
                    @elseif ($record->causer instanceof \App\Models\User)
                        Name: {{ $record->causer->name }}<br>
                        Email: {{ $record->causer->email }}
                    @else
                        {{ class_basename($record->causer_type) }} #{{ $record->causer_id }}
                    @endif
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Resource Information</div>
            <div class="field">
                <div class="field-label">Resource Type:</div>
                <div class="field-value">{{ $record->subject_type ? class_basename($record->subject_type) : 'N/A' }}</div>
            </div>
            <div class="field">
                <div class="field-label">Resource ID:</div>
                <div class="field-value">{{ $record->subject_id ?? 'N/A' }}</div>
            </div>
            <div class="field">
                <div class="field-label">Resource Details:</div>
                <div class="field-value">
                    @if (!$record->subject)
                        No resource information available
                    @elseif ($record->subject instanceof \App\Models\Challenge)
                        Challenge: {{ $record->subject->name }}<br>
                        Difficulty: {{ $record->subject->difficulty_level }}
                    @elseif ($record->subject instanceof \App\Models\Task)
                        Task: {{ $record->subject->name }}<br>
                        Challenge ID: {{ $record->subject->challenge_id }}
                    @elseif ($record->subject instanceof \App\Models\StudentAnswer)
                        Student Answer for Task #{{ $record->subject->task_id }}<br>
                        Status: {{ $record->subject->status }}
                    @else
                        Type: {{ class_basename($record->subject_type) }}<br>
                        ID: {{ $record->subject_id }}
                    @endif
                </div>
            </div>
        </div>
        
        @if ($record->properties && count($record->properties) > 0)
        <div class="section">
            <div class="section-title">Additional Properties</div>
            <table>
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->properties as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>
                            @if (is_array($value) || is_object($value))
                                {{ json_encode($value) }}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="footer">
            <p>GameLearnPro Audit Trail System</p>
            <p>This is an official record from the system audit trail.</p>
        </div>
    </div>
</body>
</html>
