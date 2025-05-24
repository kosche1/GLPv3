<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypingTestResult;
use App\Models\TypingTestChallenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TypingTestController extends Controller
{
    /**
     * Display the typing test page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get active challenges for the challenge selection
        $challenges = TypingTestChallenge::where('is_active', true)
            ->orderBy('difficulty')
            ->orderBy('test_mode')
            ->get();

        return view('typing-test.index', compact('challenges'));
    }

    /**
     * Get random words for the typing test.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getWords(Request $request)
    {
        $count = $request->input('count', 25);
        $challengeId = $request->input('challenge_id');

        try {
            // If a challenge is specified, use its word list
            if ($challengeId) {
                $challenge = TypingTestChallenge::find($challengeId);
                if ($challenge && $challenge->word_list) {
                    // Use the challenge's custom word list
                    $words = $challenge->word_list;

                    // Get random words from the challenge's word list
                    $randomWords = [];
                    for ($i = 0; $i < $count; $i++) {
                        $randomIndex = array_rand($words);
                        $randomWords[] = $words[$randomIndex];
                    }

                    return response()->json($randomWords);
                }
            }

            // Default behavior: Get words from the word bank file
            if (file_exists(resource_path('word-banks/english.txt'))) {
                $wordBank = file_get_contents(resource_path('word-banks/english.txt'));
                $words = explode("\n", $wordBank);

                // Filter out empty words
                $words = array_filter($words, function($word) {
                    return !empty(trim($word));
                });

                // Get random words
                $randomWords = [];
                for ($i = 0; $i < $count; $i++) {
                    $randomIndex = array_rand($words);
                    $randomWords[] = trim($words[$randomIndex]);
                }

                return response()->json($randomWords);
            } else {
                // Fallback to hardcoded words if file doesn't exist
                $fallbackWords = ['the', 'of', 'to', 'and', 'a', 'in', 'is', 'it', 'you', 'that', 'he', 'was', 'for', 'on', 'are', 'with', 'as', 'I', 'his', 'they', 'be', 'at', 'one', 'have', 'this'];

                // Ensure we have enough words
                $randomWords = [];
                for ($i = 0; $i < $count; $i++) {
                    $randomWords[] = $fallbackWords[$i % count($fallbackWords)];
                }

                return response()->json($randomWords);
            }
        } catch (\Exception $exception) {
            // Log the error
            Log::error('Error fetching words for typing test: ' . $exception->getMessage());
            // Fallback to hardcoded words if there's an error
            $fallbackWords = ['the', 'of', 'to', 'and', 'a', 'in', 'is', 'it', 'you', 'that', 'he', 'was', 'for', 'on', 'are', 'with', 'as', 'I', 'his', 'they', 'be', 'at', 'one', 'have', 'this'];

            // Ensure we have enough words
            $randomWords = [];
            for ($i = 0; $i < $count; $i++) {
                $randomWords[] = $fallbackWords[$i % count($fallbackWords)];
            }

            return response()->json($randomWords);
        }
    }

    /**
     * Save typing test results.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveResult(Request $request)
    {
        try {
            $request->validate([
                'wpm' => 'required|numeric|min:0',
                'cpm' => 'required|numeric|min:0',
                'accuracy' => 'required|numeric|min:0|max:100',
                'word_count' => 'required|numeric|min:0',
                'test_mode' => 'required|string|in:words,time',
                'time_limit' => 'nullable|numeric|min:1',
                'test_duration' => 'nullable|numeric|min:1',
                'characters_typed' => 'nullable|numeric|min:0',
                'errors' => 'nullable|numeric|min:0',
                'challenge_id' => 'nullable|exists:typing_test_challenges,id',
            ]);

            $result = new TypingTestResult();
            $result->user_id = Auth::id();
            $result->challenge_id = $request->challenge_id;
            $result->wpm = $request->wpm;
            $result->cpm = $request->cpm;
            $result->accuracy = $request->accuracy;
            $result->word_count = $request->word_count;
            $result->test_mode = $request->test_mode;
            $result->time_limit = $request->time_limit;
            $result->test_duration = $request->test_duration ?? $request->time_limit;
            $result->words_typed = $request->word_count;
            $result->characters_typed = $request->characters_typed ?? 0;
            $result->errors = $request->errors ?? 0;
            $result->save();

            Log::info('Typing test result saved successfully', [
                'user_id' => Auth::id(),
                'result_id' => $result->id,
                'wpm' => $result->wpm,
                'accuracy' => $result->accuracy
            ]);

            return response()->json(['success' => true, 'result_id' => $result->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error saving typing test result', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error saving typing test result', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to save result: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get challenge details by ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getChallenge(Request $request)
    {
        $challengeId = $request->input('challenge_id');

        if (!$challengeId) {
            return response()->json(['error' => 'Challenge ID is required'], 400);
        }

        $challenge = TypingTestChallenge::where('id', $challengeId)
            ->where('is_active', true)
            ->first();

        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], 404);
        }

        return response()->json($challenge);
    }

    /**
     * Get typing test history for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory()
    {
        $history = TypingTestResult::where('user_id', Auth::id())
            ->with('challenge:id,title,difficulty')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($history);
    }
}
