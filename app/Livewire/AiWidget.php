<?php

namespace App\Livewire;

use App\Services\AiChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Component;

class AiWidget extends Component implements HasMingles
{
    use InteractsWithMingles;

    /**
     * Store conversation history
     */
    protected $conversationHistory = [];

    /**
     * The AI Chat Service instance
     */
    protected $aiChatService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aiChatService = app(AiChatService::class);
        app('mingle')->register($this->component());
    }

    public function component(): string
    {
        return 'resources/js/AiWidget/index.js';
    }

    public function mingleData(): array
    {
        return [
            'message' => 'Message in a bottle 🍾',
            'method' => 'processMessage', // Default method for AI processing
            'user' => [
                'name' => Auth::check() ? Auth::user()->name : 'Guest',
                'avatar' => null,
            ],
            'streamingSupported' => true,
            'availableModels' => $this->aiChatService->getAvailableModels(),
            'defaultModel' => $this->aiChatService->defaultModel,
        ];
    }

    /**
     * Process a message from the user and generate an AI response
     *
     * @param string $message The user's message
     * @param bool $useStreaming Whether to use streaming response
     * @param string|null $modelName Optional model name to override default
     * @return array Response data
     */
    public function processMessage(string $message, bool $useStreaming = false, ?string $modelName = null): array
    {
        try {
            if ($useStreaming) {
                // For streaming, we'll return a placeholder and handle streaming in the frontend
                return [
                    'content' => '',
                    'timestamp' => Date::now()->format('g:i A'),
                    'streaming' => true,
                    'streamUrl' => route('ai.stream', [
                        'message' => $message,
                        'model' => $modelName
                    ]),
                ];
            } else {
                // Add user message to history
                $this->conversationHistory[] = [
                    'sender' => 'user',
                    'content' => $message,
                    'timestamp' => Date::now()->format('g:i A')
                ];

                // Generate AI response using the service
                $response = $this->aiChatService->generateResponse(
                    $message,
                    $this->conversationHistory,
                    $modelName
                );

                // Add AI response to history
                $this->conversationHistory[] = [
                    'sender' => 'ai',
                    'content' => $response['content'],
                    'timestamp' => $response['timestamp'] ?? Date::now()->format('g:i A')
                ];

                return $response;
            }
        } catch (\Exception $e) {
            return [
                'content' => 'Sorry, I encountered an error processing your request. Please try again.',
                'timestamp' => Date::now()->format('g:i A'),
                'error' => true,
                'error_message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get conversation history
     *
     * @return array
     */
    public function getConversationHistory(): array
    {
        return $this->conversationHistory;
    }

    /**
     * Clear conversation history
     *
     * @return void
     */
    public function clearConversation(): void
    {
        $this->conversationHistory = [];
    }

    /**
     * Legacy method kept for compatibility
     */
    public function doubleIt($amount)
    {
        return $amount * 2;
    }
}
