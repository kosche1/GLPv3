# Prism Tooling Documentation

## Overview

This documentation provides a comprehensive guide to using Prism's Tools and Function Calling capabilities. These features enable your AI assistant to extend its functionality by calling external services, APIs, and other functions.

## Getting Started with Tools

Tools in Prism allow your AI assistant to perform specific tasks by accessing external functions. Similar to Laravel's facades, they provide a clean interface for complex functionality.

### Basic Usage

```php
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Tool;

// Define a weather tool
$weatherTool = Tool::as('weather')
    ->for('Get current weather conditions')
    ->withStringParameter('city', 'The city to get weather for')
    ->using(function (string $city): string {
        // Weather API implementation
        return "The weather in {$city} is sunny and 72°F.";
    });

// Use the tool in a Prism call
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-latest')
    ->withMaxSteps(2)
    ->withPrompt('What is the weather like in Paris?')
    ->withTools([$weatherTool])
    ->asText();
```

## Max Steps Configuration

When using tools, you need to increase the default step limit (1) using `withMaxSteps`:

```php
Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-latest')
    ->withMaxSteps(2) // Minimum for tool usage
    ->withPrompt('What is the weather like in Paris?')
    ->withTools([$weatherTool])
    ->asText();
```

Increase this number if you expect multiple tool calls from your initial prompt.

## Creating Tools

### Basic Tool Creation

```php
use Prism\Prism\Facades\Tool;

$searchTool = Tool::as('search')
    ->for('Search for current information')
    ->withStringParameter('query', 'The search query')
    ->using(function (string $query): string {
        // Search implementation
        return "Search results for: {$query}";
    });
```

## Parameter Types

Prism supports a variety of parameter types for your tools:

### String Parameters
```php
->withStringParameter('query', 'The search query')
```

### Number Parameters
```php
->withNumberParameter('value', 'The number to process')
```

### Boolean Parameters
```php
->withBooleanParameter('enabled', 'Whether to enable the feature')
```

### Array Parameters
```php
->withArrayParameter(
    'tags',
    'List of tags to process',
    new StringSchema('tag', 'A single tag')
)
```

### Enum Parameters
```php
->withEnumParameter(
    'status',
    'The new status',
    ['draft', 'published', 'archived']
)
```

### Object Parameters
```php
->withObjectParameter(
    'user',
    'The user profile data',
    [
        new StringSchema('name', 'User\'s full name'),
        new NumberSchema('age', 'User\'s age'),
        new StringSchema('email', 'User\'s email address')
    ],
    requiredFields: ['name', 'email']
)
```

### Schema-based Parameters
For complex data structures:
```php
->withParameter(new ObjectSchema(
    name: 'user',
    description: 'The user profile data',
    properties: [
        new StringSchema('name', 'User\'s full name'),
        new NumberSchema('age', 'User\'s age'),
        new StringSchema('email', 'User\'s email address')
    ],
    requiredFields: ['name', 'email']
))
```

## Advanced Tool Implementation

For more complex tools, create dedicated classes:

```php
namespace App\Tools;

use Prism\Prism\Tool;
use Illuminate\Support\Facades\Http;

class SearchTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('search')
            ->for('useful when you need to search for current events')
            ->withStringParameter('query', 'Detailed search query. Best to search one topic at a time.')
            ->using($this);
    }

    public function __invoke(string $query): string
    {
        // Implementation
        $response = Http::get('https://serpapi.com/search', [
            'engine' => 'google',
            'q' => $query,
            'google_domain' => 'google.com',
            'gl' => 'us',
            'hl' => 'en',
            'api_key' => config('services.serpapi.api_key'),
        ]);

        // Process and return results
        // ...
    }
}
```

## Controlling Tool Usage

Control how the AI uses tools with `withToolChoice`:

```php
use Prism\Prism\Enums\ToolChoice;

// Let the AI decide whether to use tools
->withToolChoice(ToolChoice::Auto)

// Force the AI to use a tool
->withToolChoice(ToolChoice::Any)

// Force the AI to use a specific tool
->withToolChoice('weather')
```

Note: Tool choice support varies by provider.

## Handling Tool Responses

Inspect tool usage and results:

```php
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-latest')
    ->withMaxSteps(2)
    ->withPrompt('What is the weather like in Paris?')
    ->withTools([$weatherTool])
    ->asText();

// Get the final answer
echo $response->text;

// Inspect tool results
if ($response->toolResults) {
    foreach ($response->toolResults as $toolResult) {
        echo "Tool: " . $toolResult->toolName . "\n";
        echo "Result: " . $toolResult->result . "\n";
    }
}

// Inspect step-by-step tool calls
foreach ($response->steps as $step) {
    if ($step->toolCalls) {
        foreach ($step->toolCalls as $toolCall) {
            echo "Tool: " . $toolCall->name . "\n";
            echo "Arguments: " . json_encode($toolCall->arguments()) . "\n";
        }
    }
}
```

## Further Reading

For more complex parameter definitions, refer to Prism's complete schema guide to define nested objects, arrays, enums, and more advanced structures.
