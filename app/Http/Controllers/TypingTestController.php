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

        // Check which challenges the current user has completed successfully
        $userId = Auth::id();
        $completedChallengeIds = [];

        if ($userId) {
            // Get challenges where user met both WPM and accuracy targets
            $completedChallengeIds = TypingTestResult::where('user_id', $userId)
                ->whereNotNull('challenge_id')
                ->get()
                ->filter(function ($result) {
                    $challenge = $result->challenge;
                    if (!$challenge) return false;

                    // Check if user met both targets
                    $metWpmTarget = $result->wpm >= $challenge->target_wpm;
                    $metAccuracyTarget = $result->accuracy >= $challenge->target_accuracy;

                    return $metWpmTarget && $metAccuracyTarget;
                })
                ->pluck('challenge_id')
                ->unique()
                ->toArray();
        }

        // Add completion status to challenges
        $challenges = $challenges->map(function ($challenge) use ($completedChallengeIds) {
            $challenge->is_completed = in_array($challenge->id, $completedChallengeIds);
            return $challenge;
        });

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

            // Save all results to database, but mark free typing differently
            $result = new TypingTestResult();
            $result->user_id = Auth::id();
            $result->challenge_id = $request->challenge_id; // Will be null for free typing
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

            if ($request->challenge_id) {
                // Check if this result completes the challenge
                $challenge = \App\Models\TypingTestChallenge::find($request->challenge_id);
                $user = Auth::user();

                if ($challenge && $user) {
                    $metWpmTarget = $result->wpm >= $challenge->target_wpm;
                    $metAccuracyTarget = $result->accuracy >= $challenge->target_accuracy;

                    // Check if user has already completed this challenge before
                    $hasCompletedBefore = \App\Models\TypingTestResult::where('user_id', $user->id)
                        ->where('challenge_id', $challenge->id)
                        ->where('id', '!=', $result->id) // Exclude current result
                        ->get()
                        ->filter(function ($previousResult) use ($challenge) {
                            return $previousResult->wpm >= $challenge->target_wpm &&
                                   $previousResult->accuracy >= $challenge->target_accuracy;
                        })
                        ->isNotEmpty();

                    // If both targets are met and this is the first completion, record in audit trail
                    if ($metWpmTarget && $metAccuracyTarget && !$hasCompletedBefore) {
                        try {
                            // Create a pseudo-challenge object for audit trail
                            $challengeData = (object) [
                                'name' => $challenge->title,
                                'points_reward' => 0, // Typing challenges don't have points
                                'difficulty_level' => $challenge->difficulty,
                            ];

                            \App\Models\AuditTrail::recordChallengeCompletion($user, $challengeData, [
                                'challenge_type' => 'typing_test',
                                'subject_name' => 'ICT',
                                'subject_type' => 'Specialized',
                                'wpm_achieved' => $result->wpm,
                                'accuracy_achieved' => $result->accuracy,
                                'target_wpm' => $challenge->target_wpm,
                                'target_accuracy' => $challenge->target_accuracy,
                            ]);

                            Log::info('Typing test challenge completion recorded in audit trail', [
                                'user_id' => $user->id,
                                'challenge_id' => $challenge->id,
                                'challenge_title' => $challenge->title,
                                'wpm_achieved' => $result->wpm,
                                'accuracy_achieved' => $result->accuracy
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error recording typing test challenge completion: ' . $e->getMessage(), [
                                'user_id' => $user->id,
                                'challenge_id' => $challenge->id,
                                'trace' => $e->getTraceAsString()
                            ]);
                        }
                    }
                }

                Log::info('Typing test challenge result saved successfully', [
                    'user_id' => Auth::id(),
                    'result_id' => $result->id,
                    'challenge_id' => $result->challenge_id,
                    'wpm' => $result->wpm,
                    'accuracy' => $result->accuracy
                ]);

                return response()->json(['success' => true, 'result_id' => $result->id, 'type' => 'challenge']);
            } else {
                Log::info('Free typing result saved to database (not visible in admin panel)', [
                    'user_id' => Auth::id(),
                    'result_id' => $result->id,
                    'wpm' => $result->wpm,
                    'accuracy' => $result->accuracy,
                    'test_mode' => $result->test_mode
                ]);

                return response()->json(['success' => true, 'result_id' => $result->id, 'type' => 'free_typing']);
            }
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
     * Includes both challenge results and free typing results from database
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory()
    {
        // Get all results from database (both challenges and free typing)
        $allResults = TypingTestResult::where('user_id', Auth::id())
            ->with('challenge:id,title,difficulty')
            ->orderBy('created_at', 'desc')
            ->limit(20) // Increased limit since we're showing both types
            ->get();

        return response()->json($allResults);
    }

    /**
     * Delete a free typing result for the current user
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFreeTypingResult($id)
    {
        try {
            // Find the result and ensure it belongs to the current user and is free typing
            $result = TypingTestResult::where('id', $id)
                ->where('user_id', Auth::id())
                ->whereNull('challenge_id') // Only allow deletion of free typing results
                ->first();

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Free typing result not found or you do not have permission to delete it.'
                ], 404);
            }

            $result->delete();

            Log::info('Free typing result deleted by user', [
                'user_id' => Auth::id(),
                'result_id' => $id,
                'wpm' => $result->wpm,
                'accuracy' => $result->accuracy
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Free typing result deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting free typing result', [
                'user_id' => Auth::id(),
                'result_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the result.'
            ], 500);
        }
    }

}
