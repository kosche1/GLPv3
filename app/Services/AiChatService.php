<?php

namespace App\Services;

use App\Tools\LevelUpDataTool;
use Exception;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\PrismServer;
use Prism\Prism\Prism;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Prism\Prism\ValueObjects\Messages\SystemMessage;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class AiChatService
{
    /**
     * Default model to use when none is specified
     *
     * @var string
     */
    public $defaultModel = 'Gemini 2.0 Flash';

    /**
     * The LevelUpDataTool instance
     *
     * @var LevelUpDataTool
     */
    protected $levelUpDataTool;

    /**
     * Constructor
     */
    public function __construct(LevelUpDataTool $levelUpDataTool)
    {
        $this->levelUpDataTool = $levelUpDataTool;
    }

    /**
     * Generate a response to a user message
     *
     * @param  string  $userMessage  The user's message
     * @param  array  $history  Previous conversation history
     * @param  string|null  $modelName  Optional model name to override default
     * @param  bool  $useStreaming  Whether to use streaming response
     * @return array Response data with content and metadata
     */
    public function generateResponse(string $userMessage, array $history = [], ?string $modelName = null, bool $useStreaming = false): array
    {
        $modelToUse = $modelName ?? $this->defaultModel;
        $messages = $this->buildMessageHistory($history, $userMessage, $modelToUse);

        try {
            // Get provider and model details
            [$provider, $model] = $this->mapModelToProviderAndModel($modelToUse);

            // Check if streaming is supported for this provider
            $supportsStreaming = in_array(strtolower($provider), ['openai', 'anthropic', 'gemini']);
            $shouldStream = $useStreaming && $supportsStreaming;

            // Create the Prism request
            $prismRequest = Prism::text()
                ->using($provider, $model)
                ->withMessages($messages)
                ->usingTemperature(0.7)
                ->withMaxSteps(3)
                ->withTools([$this->levelUpDataTool])
                ->withMaxTokens(1000);

            if ($shouldStream) {
                // Handle streaming response
                $stream = $prismRequest->asStream();
                $fullResponse = '';

                foreach ($stream as $chunk) {
                    $fullResponse .= $chunk->text ?? '';
                    // In a real app, you would send this chunk to the client
                    // This is handled by the AiStreamController
                }

                return [
                    'content' => $fullResponse,
                    'model' => $modelToUse,
                    'provider' => $provider,
                    'timestamp' => now()->format('g:i A'),
                    'streaming' => true,
                    'complete' => true,
                ];
            } else {
                // Handle regular response - use asText() for text generation
                $response = $prismRequest->asText();

                return [
                    'content' => $response->text,
                    'model' => $modelToUse,
                    'provider' => $provider,
                    'timestamp' => now()->format('g:i A'),
                    'streaming' => false,
                ];
            }
        } catch (Exception $e) {
            Log::error('AI Chat Error: '.$e->getMessage(), [
                'user_message' => $userMessage,
                'model' => $modelToUse,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'content' => 'Sorry, I encountered an error processing your request. Please try again.',
                'model' => $modelToUse,
                'timestamp' => now()->format('g:i A'),
                'error' => true,
                'error_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate a streaming response for Server-Sent Events
     *
     * @param  string  $userMessage  The user's message
     * @param  array  $history  Previous conversation history
     * @param  string|null  $modelName  Optional model name to override default
     * @return \Illuminate\Support\Collection The streaming response
     */
    public function generateStreamingResponse(string $userMessage, array $history = [], ?string $modelName = null)
    {
        $modelToUse = $modelName ?? $this->defaultModel;
        $messages = $this->buildMessageHistory($history, $userMessage, $modelToUse);

        try {
            // Get provider and model details
            [$provider, $model] = $this->mapModelToProviderAndModel($modelToUse);

            // Create the Prism request
            $prismRequest = Prism::text()
                ->using($provider, $model)
                ->withMessages($messages)
                ->usingTemperature(0.7)
                ->withMaxSteps(3)
                ->withTools([$this->levelUpDataTool])
                ->withMaxTokens(1000);

            // Return the stream
            return $prismRequest->asStream();

        } catch (Exception $e) {
            Log::error('AI Chat Streaming Error: '.$e->getMessage(), [
                'user_message' => $userMessage,
                'model' => $modelToUse,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Build message history including system prompt and user message
     *
     * @param  array  $history  Previous conversation history
     * @param  string|null  $userMessage  Current user message to append (optional)
     * @param  string|null  $modelName  Optional model name to determine message format
     * @return array Formatted message history for Prism
     */
    private function buildMessageHistory(array $history, ?string $userMessage = null, ?string $modelName = null): array
    {
        $messages = [];

        // Get provider to determine message format
        $providerInfo = $this->mapModelToProviderAndModel($modelName ?? $this->defaultModel);
        $provider = $providerInfo[0]; // Extract just the provider
        $isGemini = strtolower($provider) === strtolower(Provider::Gemini->value);

        // System message handling
        $systemContent = "You are an AI assistant. You have access to a tool called 'level_up_data'.\n" .
            "**MUST USE TOOL:** When asked about the user's level, XP, experience, achievements, streaks, or leaderboard, you **MUST** use the 'level_up_data' tool.\n" .
            "Available query types for 'level_up_data':\n" .
            "- get_user_level: User's level and XP.\n" .
            "- get_user_experience: Detailed XP history.\n" .
            "- get_user_achievements: User's achievements (unlocked and progress).\n" .
            "- get_user_streaks: User's activity streaks.\n" .
            "- get_leaderboard: Top users by XP (optional 'limit').\n" .
            "Examples: \"What level am I?\" -> use 'get_user_level'. \"My achievements?\" -> use 'get_user_achievements'. \"Leaderboard\" -> use 'get_leaderboard'.\n" .
            "Do **NOT** say you cannot access this information. Use the tool.";

        if ($isGemini) {
            // For Gemini, add the system content as part of the first user message
            // or as a separate user message if there's no history
            if (empty($history) && $userMessage === null) {
                $messages[] = new UserMessage("System: {$systemContent}");
            } elseif (!empty($history)) {
                // System instructions are already in history, no need to add again
            } else {
                // Will be combined with the user message later
                $combinedMessage = "System: {$systemContent}\n\nUser: {$userMessage}";
                // Clear the original message as we'll add the combined one at the end
                $userMessage = null;
                // Add the combined message now
                $messages[] = new UserMessage($combinedMessage);
            }
        } else {
            // For other providers, we can use a proper SystemMessage
            $messages[] = new SystemMessage($systemContent);
        }

        // Convert history items to Prism Message objects
        foreach ($history as $item) {
            if ($item['sender'] === 'user') {
                $messages[] = new UserMessage($item['content']);
            } else {
                $messages[] = new AssistantMessage($item['content']);
            }
        }

        // Add the current user message if provided
        if ($userMessage !== null) {
            $messages[] = new UserMessage($userMessage);
        }

        return $messages;
    }

    /**
     * Get available AI models
     *
     * @return array List of available models
     */
    public function getAvailableModels(): array
    {
        // Prefer registered models via PrismServer if configured
        $registeredModels = PrismServer::prisms()->pluck('name')->toArray();
        if (! empty($registeredModels)) {
            return $registeredModels;
        }

        // Fallback to hardcoded list
        return [
            'Gemini 1.5 Flash',
            'Gemini 1.5 Pro',
            'GPT-4o',
            'GPT-3.5 Turbo',
            'Claude 3 Haiku',
        ];
    }

    /**
     * Map a model identifier to a provider and model name
     *
     * @param  string  $modelIdentifier  The model identifier/name
     * @return array [provider, model] tuple
     */
    private function mapModelToProviderAndModel(string $modelIdentifier): array
    {
        // First check if this is a registered Prism model
        $prisms = PrismServer::prisms();
        $prism = $prisms->firstWhere('name', $modelIdentifier);

        if ($prism) {
            $provider = $prism['provider'] ?? Provider::Gemini->value;
            $model = $prism['model'] ?? 'gemini-2.0-flash';

            return [$provider, $model];
        }

        // Fallback mapping for common models
        $providerMap = [
            'Gemini 1.5 Flash' => [Provider::Gemini->value, 'gemini-1.5-flash'],
            'Gemini 1.5 Pro' => [Provider::Gemini->value, 'gemini-1.5-pro'],
            'GPT-4o' => [Provider::OpenAI->value, 'gpt-4o'],
            'GPT-3.5 Turbo' => [Provider::OpenAI->value, 'gpt-3.5-turbo'],
            'Claude 3 Haiku' => [Provider::Anthropic->value, 'claude-3-haiku-20240307'],
        ];

        // Case-insensitive lookup
        foreach ($providerMap as $name => $details) {
            if (strcasecmp($modelIdentifier, $name) === 0) {
                return $details;
            }
        }

        // Default to Gemini if not found
        Log::warning('Model identifier not found. Defaulting to Gemini 1.5 Flash.', [
            'identifier' => $modelIdentifier,
        ]);

        return [Provider::Gemini->value, 'gemini-2.0-flash'];
    }
}
