# Task Expected Output Guide

The `expected_output` field in the Task model provides a flexible way to compare student answers with expected results. This feature allows for different types of output validation, from exact matches to pattern recognition.

## Field Structure

The `expected_output` is stored as a JSON object in the database and is cast to an array in the Task model. It supports several comparison methods based on the `type` specified:

```php
$task->expected_output = [
    'type' => 'comparison_type',
    'value' => 'expected_value', // or 'values', 'pattern' depending on type
    // Other type-specific properties
];
```

## Comparison Types

### 1. Exact Match (`exact_match`)

Compares the student's output directly with the expected value after normalization (trimming whitespace, converting to lowercase, etc.).

```php
'expected_output' => [
    'type' => 'exact_match',
    'value' => 'Expected output text here'
]
```

### 2. Contains Substrings (`contains`)

Checks if the student's output contains all the specified substrings, regardless of their order.

```php
'expected_output' => [
    'type' => 'contains',
    'values' => [
        'first required phrase',
        'second required phrase',
        'must have this too'
    ]
]
```

### 3. Regular Expression Match (`regex`)

Uses a regular expression pattern to validate the student's output.

```php
'expected_output' => [
    'type' => 'regex',
    'pattern' => '/^The answer is (\d+)$/'
]
```

### 4. Key-Value Match (`key_value_match`)

Used for structured outputs (like JSON or arrays) to check if certain key-value pairs exist in the output.

```php
'expected_output' => [
    'type' => 'key_value_match',
    'values' => [
        'status' => 'success',
        'data_count' => 10,
        'is_complete' => true
    ]
]
```

## Usage Examples

### Python Output Validation

```php
// For a Python data processing task
Task::create([
    'name' => 'Data Cleaning Function',
    // ...other fields...
    'expected_output' => [
        'type' => 'contains',
        'values' => [
            'loaded data',
            'cleaned',
            'processed'
        ]
    ]
]);
```

### SQL Query Result Validation

```php
// For an SQL query that should return specific results
Task::create([
    'name' => 'Employee Query',
    // ...other fields...
    'expected_output' => [
        'type' => 'regex',
        'pattern' => '/Found (\d+) employees in the (Sales|Marketing) department/'
    ]
]);
```

### Web Development API Response

```php
// For validating a JSON API response
Task::create([
    'name' => 'Create REST API Endpoint',
    // ...other fields...
    'expected_output' => [
        'type' => 'key_value_match',
        'values' => [
            'statusCode' => 200,
            'hasData' => true
        ]
    ]
]);
```

## Implementation Details

When a student submits an answer, the system:

1. Extracts the output from their submission
2. Determines the comparison type from the task's `expected_output`
3. Normalizes both the expected output and student output (when appropriate)
4. Performs the comparison based on the specified type
5. Returns a pass/fail result

## Fallback Mechanism

If the `expected_output` field is not set, the system falls back to using the `answer_key` field for backward compatibility.

## Adding New Comparison Types

To add a new comparison type, update the `checkAnswer` method in the Task model with the new comparison logic. 