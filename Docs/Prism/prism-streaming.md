# Prism Streaming Output - README

## Overview

This README explains how to implement streaming AI responses with Prism, allowing you to display AI-generated text in real-time as it's being created, rather than waiting for the complete response.

## Basic Streaming Implementation

```php
use Prism\Prism\Prism;

$response = Prism::text()
    ->using('openai', 'gpt-4')
    ->withPrompt('Tell me a story about a brave knight.')
    ->asStream();

foreach ($response as $chunk) {
    echo $chunk->text;
    // Flush output buffer for immediate display
    ob_flush();
    flush();
}
```

## Working with Chunks

Each chunk in the stream contains a fragment of the generated content:

```php
foreach ($response as $chunk) {
    // Output the text fragment
    echo $chunk->text;

    // Check if this is the final chunk
    if ($chunk->finishReason) {
        echo "Generation complete: " . $chunk->finishReason->name;
    }
}
```

## Streaming with Tools

Prism supports streaming with tools for interactive AI applications:

```php
use Prism\Prism\Facades\Tool;
use Prism\Prism\Prism;

$weatherTool = Tool::as('weather')
    ->for('Get current weather information')
    ->withStringParameter('city', 'City name')
    ->using(function (string $city) {
        return "The weather in {$city} is sunny and 72°F.";
    });

$response = Prism::text()
    ->using('openai', 'gpt-4o')
    ->withTools([$weatherTool])
    ->withMaxSteps(3)
    ->withPrompt('What\'s the weather like in San Francisco today?')
    ->asStream();

$fullResponse = '';
foreach ($response as $chunk) {
    $fullResponse .= $chunk->text;

    // Handle tool calls
    if ($chunk->toolCalls) {
        foreach ($chunk->toolCalls as $call) {
            echo "Tool called: " . $call->name;
        }
    }

    // Handle tool results
    if ($chunk->toolResults) {
        foreach ($chunk->toolResults as $result) {
            echo "Tool result: " . $result->result;
        }
    }
}
```

## Web Application Integration

### Laravel Controller Example

```php
use Prism\Prism\Prism;
use Illuminate\Http\Response;

public function streamResponse()
{
    return response()->stream(function () {
        $stream = Prism::text()
            ->using('openai', 'gpt-4')
            ->withPrompt('Explain quantum computing step by step.')
            ->asStream();

        foreach ($stream as $chunk) {
            echo $chunk->text;
            ob_flush();
            flush();
        }
    }, 200, [
        'Cache-Control' => 'no-cache',
        'Content-Type' => 'text/event-stream',
        'X-Accel-Buffering' => 'no', // Prevents Nginx from buffering
    ]);
}
```

### Laravel 12 Event Streams

```php
Route::get('/chat', function () {
    return response()->eventStream(function () {
        $stream = Prism::text()
            ->using('openai', 'gpt-4')
            ->withPrompt('Explain quantum computing step by step.')
            ->asStream();

        foreach ($stream as $response) {
            yield $response->text;
        }
    });
});
```

## Benefits

- More responsive user experience
- Feels more natural and engaging
- Especially beneficial for longer responses
- Supports complex interactions with tools

## License
