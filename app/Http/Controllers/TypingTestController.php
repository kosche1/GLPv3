<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypingTestResult;
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
        return view('typing-test.index');
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

        try {
            // Get words from the word bank file
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
        $request->validate([
            'wpm' => 'required|numeric',
            'cpm' => 'required|numeric',
            'accuracy' => 'required|numeric',
            'word_count' => 'required|numeric',
            'test_mode' => 'required|string|in:words,time',
            'time_limit' => 'nullable|numeric',
        ]);

        $result = new TypingTestResult();
        $result->user_id = Auth::id();
        $result->wpm = $request->wpm;
        $result->cpm = $request->cpm;
        $result->accuracy = $request->accuracy;
        $result->word_count = $request->word_count;
        $result->test_mode = $request->test_mode;
        $result->time_limit = $request->time_limit;
        $result->save();

        return response()->json(['success' => true, 'result_id' => $result->id]);
    }

    /**
     * Get typing test history for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory()
    {
        $history = TypingTestResult::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($history);
    }
}
