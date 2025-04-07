<?php

namespace App\Http\Controllers;

use App\Services\AiChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AiStreamController extends Controller
{
    /**
     * @var AiChatService
     */
    protected $aiChatService;

    /**
     * Constructor
     */
    public function __construct(AiChatService $aiChatService)
    {
        $this->aiChatService = $aiChatService;
    }

    /**
     * Stream AI response
     *
     * @param Request $request
     * @return StreamedResponse
     */
    public function stream(Request $request)
    {
        $message = $request->input('message');
        $modelName = $request->input('model', null); // Optional model override
        $history = $request->session()->get('ai_chat_history', []);

        // Add the user message to history
        $history[] = [
            'sender' => 'user',
            'content' => $message,
            'timestamp' => now()->format('g:i A')
        ];

        // Store history in session
        $request->session()->put('ai_chat_history', $history);

        return response()->stream(function () use ($message, $modelName, $history, $request) {
            try {
                $stream = $this->aiChatService->generateStreamingResponse($message, $history, $modelName);

                // Send the SSE headers
                echo "data: " . json_encode(['type' => 'start']) . "\n\n";
                ob_flush();
                flush();

                $fullResponse = '';

                // Stream each chunk as it comes in
                foreach ($stream as $chunk) {
                    $contentChunk = $chunk->text ?? '';
                    $fullResponse .= $contentChunk;

                    if (!empty($contentChunk)) {
                        echo "data: " . json_encode([
                            'type' => 'chunk',
                            'content' => $contentChunk,
                        ]) . "\n\n";
                        ob_flush();
                        flush();
                    }

                    // Small delay to prevent overwhelming the client
                    usleep(10000); // 10ms
                }

                // Add the AI response to history
                $history[] = [
                    'sender' => 'ai',
                    'content' => $fullResponse,
                    'timestamp' => now()->format('g:i A')
                ];

                // Update history in session
                $request->session()->put('ai_chat_history', $history);

                // Send completion message
                echo "data: " . json_encode([
                    'type' => 'end',
                    'content' => $fullResponse,
                    'model' => $modelName ?? $this->aiChatService->defaultModel,
                    'timestamp' => now()->format('g:i A')
                ]) . "\n\n";
                ob_flush();
                flush();

            } catch (\Exception $e) {
                Log::error('AI Streaming Error: ' . $e->getMessage(), [
                    'message' => $message,
                    'model' => $modelName,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Send error message
                echo "data: " . json_encode([
                    'type' => 'error',
                    'message' => 'Sorry, I encountered an error processing your request: ' . $e->getMessage(),
                ]) . "\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }
}
