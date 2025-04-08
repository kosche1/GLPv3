# Prism Text Generation Library

Prism is a powerful PHP library for generating text using Large Language Models (LLMs). This readme provides an overview of the library's features and usage.

## Installation

```bash
composer require prism/prism
```

## Basic Usage

```php
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withPrompt('Tell me a short story about a brave knight.')
    ->asText();

echo $response->text;
```

## Key Features

### System Prompts and Context

Set behavior and context for the AI:

```php
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withSystemPrompt('You are an expert mathematician who explains concepts simply.')
    ->withPrompt('Explain the Pythagorean theorem.')
    ->asText();
```

You can use Laravel views for complex system prompts:

```php
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withSystemPrompt(view('prompts.math-tutor'))
    ->withPrompt('What is calculus?')
    ->asText();
```

### Conversations

Maintain context with message chains:

```php
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;

$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withMessages([
        new UserMessage('What is JSON?'),
        new AssistantMessage('JSON is a lightweight data format...'),
        new UserMessage('Can you show me an example?')
    ])
    ->asText();
```

### Message Types

- `SystemMessage`
- `UserMessage`
- `AssistantMessage`
- `ToolResultMessage`

**Note:** Some providers like Anthropic do not support `SystemMessage` type and will automatically convert it to `UserMessage`.

### Generation Parameters

Fine-tune your generations:

```php
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withMaxTokens(1000)
    ->usingTemperature(0.7)
    ->usingTopP(0.9)
    ->withClientOptions(['timeout' => 30])
    ->withClientRetry(3, 100)
    ->withPrompt('Generate creative content...')
    ->asText();
```

### Response Handling

```php
// Access the generated text
echo $response->text;

// Check why the generation stopped
echo $response->finishReason->name;

// Get token usage statistics
echo "Prompt tokens: {$response->usage->promptTokens}";
echo "Completion tokens: {$response->usage->completionTokens}";

// For multi-step generations, examine each step
foreach ($response->steps as $step) {
    echo "Step text: {$step->text}";
    echo "Step tokens: {$step->usage->completionTokens}";
}

// Access message history
foreach ($response->responseMessages as $message) {
    if ($message instanceof AssistantMessage) {
        echo $message->content;
    }
}
```

### Error Handling

```php
use Prism\Prism\Exceptions\PrismException;
use Throwable;

try {
    $response = Prism::text()
        ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
        ->withPrompt('Generate text...')
        ->asText();
} catch (PrismException $e) {
    Log::error('Text generation failed:', ['error' => $e->getMessage()]);
} catch (Throwable $e) {
    Log::error('Generic error:', ['error' => $e->getMessage()]);
}
```

## Multi-tenant Support

Override provider configuration for different users:

```php
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->usingProviderConfig(['api_key' => $userApiKey])
    ->withPrompt('Generate content...')
    ->asText();
```
