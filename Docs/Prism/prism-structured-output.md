# Prism Structured Output - README

## Overview

Prism's Structured Output functionality allows you to receive AI responses in well-defined data structures rather than raw text. This is particularly useful for building APIs, processing forms, or any application where you need data in a specific format.

## Quick Start

```php
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

// Define your data schema
$schema = new ObjectSchema(
    name: 'movie_review',
    description: 'A structured movie review',
    properties: [
        new StringSchema('title', 'The movie title'),
        new StringSchema('rating', 'Rating out of 5 stars'),
        new StringSchema('summary', 'Brief review summary')
    ],
    requiredFields: ['title', 'rating', 'summary']
);

// Request structured data
$response = Prism::structured()
    ->using(Provider::OpenAI, 'gpt-4o')
    ->withSchema($schema)
    ->withPrompt('Review the movie Inception')
    ->asStructured();

// Access your structured data
$review = $response->structured;
echo $review['title'];    // "Inception"
echo $review['rating'];   // "5 stars"
echo $review['summary'];  // "A mind-bending..."
```

## Output Modes

Prism supports two primary structured output modes, depending on the AI provider:

- **Structured Mode**: Strict schema validation ensuring responses match your defined structure
- **JSON Mode**: Guaranteed valid JSON output that approximately follows your schema

Refer to your specific provider's documentation to understand which mode they support.

## Provider-Specific Options

Some providers offer additional configuration options for structured output:

```php
$response = Prism::structured()
    ->withProviderMeta(Provider::OpenAI, [
        'schema' => [
            'strict' => true
        ]
    ])
    // Additional configuration...
    ->asStructured();
```

## Response Handling

```php
// Access the structured data as a PHP array
$data = $response->structured;

// Get the raw response text if needed
echo $response->text;

// Check why the generation stopped
echo $response->finishReason->name;

// Get token usage statistics
echo "Prompt tokens: {$response->usage->promptTokens}";
echo "Completion tokens: {$response->usage->completionTokens}";

// Access provider-specific response data
$rawResponse = $response->response;
```

## Response Validation

Always validate the structured data before using it:

```php
if ($response->structured === null) {
    // Handle parsing failure
}

if (!isset($response->structured['required_field'])) {
    // Handle missing required data
}
```

## Configuration Options

### Model Configuration
- `maxTokens` - Set maximum token generation limit
- `temperature` - Control output randomness
- `topP` - Alternative randomness control

### Input Methods
- `withPrompt` - Single prompt for generation
- `withMessages` - Message history for context
- `withSystemPrompt` - System-level instructions

### Request Configuration
- `withClientOptions` - Set HTTP client options
- `withClientRetry` - Configure automatic retries
- `usingProviderConfig` - Override provider configuration
- `withProviderMeta` - Set provider-specific options

## Error Handling

```php
use Prism\Prism\Exceptions\PrismException;

try {
    $response = Prism::structured()
        ->using('anthropic', 'claude-3-sonnet')
        ->withSchema($schema)
        ->withPrompt('Generate product data')
        ->asStructured();
} catch (PrismException $e) {
    // Handle validation or generation errors
    Log::error('Structured generation failed:', [
        'error' => $e->getMessage()
    ]);
}
```

## Limitations

Unlike text generation, structured output does not support tools/function calling. For those features, use the text generation API instead.
