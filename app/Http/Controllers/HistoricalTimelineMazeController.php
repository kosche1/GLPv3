<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\HistoricalTimelineMaze;
use App\Models\HistoricalTimelineMazeQuestion;
use App\Models\HistoricalTimelineMazeProgress;
use App\Models\HistoricalTimelineMazeLeaderboard;
use App\Models\HistoricalTimelineMazeResult;
use App\Models\HistoricalTimelineMazeEvent;

class HistoricalTimelineMazeController extends Controller
{
    /**
     * Display the Historical Timeline Maze game page.
     */
    public function index(): View
    {
        // Get the active Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)
            ->with(['easyQuestions', 'mediumQuestions', 'hardQuestions'])
            ->first();

        // Data for the Historical Timeline Maze game
        $data = [
            'trackName' => 'HUMMS',
            'pageTitle' => 'Historical Timeline Maze',
            'user' => Auth::user(),
            'historicalTimelineMaze' => $historicalTimelineMaze
        ];

        return view('historical-timeline-maze.index', $data);
    }

    /**
     * Get questions for the Historical Timeline Maze game.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions(Request $request)
    {
        // Get the active Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)->first();

        if (!$historicalTimelineMaze) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        // Get questions by era and difficulty
        $era = $request->input('era', 'ancient');
        $difficulty = $request->input('difficulty', 'easy');

        $questions = HistoricalTimelineMazeQuestion::where('historical_timeline_maze_id', $historicalTimelineMaze->id)
            ->where('era', $era)
            ->where('difficulty', $difficulty)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'questions' => $questions
        ]);
    }

    /**
     * Get events for the Historical Timeline Maze game.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(Request $request)
    {
        // Get the active Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)->first();

        if (!$historicalTimelineMaze) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        // Get events by era
        $era = $request->input('era', 'ancient');

        $events = $historicalTimelineMaze->eraEvents($era)
            ->where('is_active', true)
            ->get();

        // Format the response with era information
        $eraInfo = [
            'ancient' => [
                'title' => 'Ancient History (3000 BCE - 500 CE)',
                'description' => 'The ancient period saw the rise of early civilizations, the development of writing, and the foundation of major philosophical and religious traditions.',
            ],
            'medieval' => [
                'title' => 'Medieval Period (500 - 1500 CE)',
                'description' => 'The medieval period was characterized by feudalism, the rise of powerful empires, and significant religious developments across the world.',
            ],
            'renaissance' => [
                'title' => 'Renaissance & Early Modern (1500 - 1800 CE)',
                'description' => 'A period of cultural, artistic, political, and economic "rebirth" following the Middle Ages, marked by renewed interest in classical learning.',
            ],
            'modern' => [
                'title' => 'Modern Era (1800 - 1945 CE)',
                'description' => 'A period of rapid industrialization, technological advancement, and significant political and social changes across the globe.',
            ],
            'contemporary' => [
                'title' => 'Contemporary History (1945 - Present)',
                'description' => 'The post-World War II era characterized by the Cold War, decolonization, rapid technological advancement, and globalization.',
            ],
        ];

        return response()->json([
            'era' => $era,
            'title' => $eraInfo[$era]['title'],
            'description' => $eraInfo[$era]['description'],
            'events' => $events
        ]);
    }

    /**
     * Save user's game progress and score.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveProgress(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'era' => 'required|string',
            'difficulty' => 'required|string',
            'time_taken' => 'required|integer',
            'questions_answered' => 'required|integer',
            'correct_answers' => 'required|integer',
            'max_streak' => 'required|integer',
            'answers' => 'nullable',
            'completed' => 'required',
        ]);

        // Parse the answers JSON if it's a string
        $answers = $request->answers;
        if (is_string($answers)) {
            $answers = json_decode($answers, true);
        }

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        // Get the active Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)->first();
        if (!$historicalTimelineMaze) {
            return response()->json([
                'success' => false,
                'message' => 'Game not found',
            ], 404);
        }

        // Calculate accuracy
        $accuracy = 0;
        if ($request->questions_answered > 0) {
            $accuracy = ($request->correct_answers / $request->questions_answered) * 100;
        }

        // Save progress to the database
        $progress = HistoricalTimelineMazeProgress::create([
            'user_id' => $user->id,
            'historical_timeline_maze_id' => $historicalTimelineMaze->id,
            'era' => $request->era,
            'difficulty' => $request->difficulty,
            'score' => $request->score,
            'time_taken' => $request->time_taken,
            'questions_answered' => $request->questions_answered,
            'correct_answers' => $request->correct_answers,
            'accuracy' => $accuracy,
            'max_streak' => $request->max_streak,
            'answers' => $answers,
            'completed' => filter_var($request->completed, FILTER_VALIDATE_BOOLEAN),
        ]);

        // If the game is completed, save to results table (like typing test)
        if (filter_var($request->completed, FILTER_VALIDATE_BOOLEAN)) {
            // Save detailed result for history tracking
            $result = HistoricalTimelineMazeResult::create([
                'user_id' => $user->id,
                'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                'era_id' => null, // We'll set this if needed
                'score' => $request->score,
                'questions_attempted' => $request->questions_answered,
                'questions_correct' => $request->correct_answers,
                'accuracy_percentage' => $accuracy,
                'time_spent_seconds' => $request->time_taken,
                'completed' => true,
                'notes' => "Era: {$request->era}, Difficulty: {$request->difficulty}",
                'difficulty' => $request->difficulty,
                'era' => $request->era,
            ]);

            Log::info('Historical Timeline Maze result saved successfully', [
                'user_id' => $user->id,
                'result_id' => $result->id,
                'era' => $request->era,
                'difficulty' => $request->difficulty,
                'score' => $request->score,
                'accuracy' => $accuracy
            ]);

            // Record completion in audit trail
            try {
                    // Create a pseudo-challenge object for audit trail
                    $challengeData = (object) [
                        'name' => "Historical Timeline Maze - {$request->era} ({$request->difficulty})",
                        'points_reward' => 0, // Timeline maze doesn't have points
                        'difficulty_level' => $request->difficulty,
                    ];

                    \App\Models\AuditTrail::recordChallengeCompletion($user, $challengeData, [
                        'challenge_type' => 'historical_timeline_maze',
                        'subject_name' => 'HUMMS',
                        'subject_type' => 'Specialized',
                        'score' => $request->score, // This will be used as the main score field
                        'era' => $request->era,
                        'difficulty' => $request->difficulty,
                        'time_taken' => $request->time_taken,
                        'accuracy' => $accuracy,
                        'questions_answered' => $request->questions_answered,
                        'correct_answers' => $request->correct_answers,
                    ]);

                    \Illuminate\Support\Facades\Log::info('Historical Timeline Maze completion recorded in audit trail', [
                        'user_id' => $user->id,
                        'era' => $request->era,
                        'difficulty' => $request->difficulty,
                        'score' => $request->score,
                        'accuracy' => $accuracy
                    ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error recording Historical Timeline Maze completion: ' . $e->getMessage(), [
                    'user_id' => $user->id,
                    'era' => $request->era,
                    'difficulty' => $request->difficulty,
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress saved successfully',
            'progress_id' => $progress->id,
        ]);
    }



    /**
     * Save a detailed result of the game.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'score' => 'required|integer',
            'era' => 'required|string',
            'difficulty' => 'required|string',
            'questions_attempted' => 'required|integer',
            'questions_correct' => 'required|integer',
            'time_spent_seconds' => 'required|integer',
            'completed' => 'required|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the active Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)->first();

        if (!$historicalTimelineMaze) {
            return response()->json([
                'success' => false,
                'message' => 'No active historical timeline maze game found',
            ], 404);
        }

        // Get the era ID
        $era = HistoricalTimelineMazeEvent::where('era', $request->input('era'))
            ->where('historical_timeline_maze_id', $historicalTimelineMaze->id)
            ->where('is_active', true)
            ->first();

        $eraId = $era ? $era->id : null;

        // Calculate accuracy percentage
        $questionsAttempted = $request->input('questions_attempted');
        $questionsCorrect = $request->input('questions_correct');
        $accuracyPercentage = $questionsAttempted > 0
            ? ($questionsCorrect / $questionsAttempted) * 100
            : 0;

        // Create the result record
        $result = new HistoricalTimelineMazeResult([
            'user_id' => Auth::id(),
            'historical_timeline_maze_id' => $historicalTimelineMaze->id,
            'era_id' => $eraId,
            'score' => $request->input('score'),
            'questions_attempted' => $questionsAttempted,
            'questions_correct' => $questionsCorrect,
            'accuracy_percentage' => $accuracyPercentage,
            'time_spent_seconds' => $request->input('time_spent_seconds'),
            'completed' => $request->input('completed'),
            'notes' => $request->input('notes'),
        ]);

        $result->save();

        return response()->json([
            'success' => true,
            'message' => 'Result saved successfully',
            'result' => $result,
        ]);
    }

    /**
     * Get the user's historical timeline maze results history.
     *
     * @return JsonResponse
     */
    public function getResults(): JsonResponse
    {
        $user = Auth::user();

        // Get results ordered by date (newest first)
        $results = HistoricalTimelineMazeResult::where('user_id', $user->id)
            ->with(['historicalTimelineMaze:id,title', 'era:id,era,title'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($results);
    }

    /**
     * Delete a user's historical timeline maze result.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteResult(int $id): JsonResponse
    {
        try {
            $user = Auth::user();

            // Find the result and ensure it belongs to the current user
            $result = HistoricalTimelineMazeResult::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Result not found or you do not have permission to delete it.'
                ], 404);
            }

            // Delete the result
            $result->delete();

            return response()->json([
                'success' => true,
                'message' => 'Result deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting historical timeline maze result: ' . $e->getMessage(), [
                'result_id' => $id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting result. Please try again.'
            ], 500);
        }
    }

    /**
     * Get the leaderboard for a specific era and difficulty.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLeaderboard(Request $request)
    {
        $request->validate([
            'era' => 'required|string',
            'difficulty' => 'required|string',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = $request->input('limit', 10);

        // Get the leaderboard entries
        $leaderboard = HistoricalTimelineMazeLeaderboard::where('era', $request->era)
            ->where('difficulty', $request->difficulty)
            ->orderBy('rank', 'asc')
            ->limit($limit)
            ->get();

        // Get the current user's rank if authenticated
        $userRank = null;
        if (Auth::check()) {
            $userEntry = HistoricalTimelineMazeLeaderboard::where('user_id', Auth::id())
                ->where('era', $request->era)
                ->where('difficulty', $request->difficulty)
                ->first();

            if ($userEntry) {
                $userRank = [
                    'rank' => $userEntry->rank,
                    'score' => $userEntry->score,
                    'time_taken' => $userEntry->time_taken,
                    'accuracy' => $userEntry->accuracy,
                ];
            }
        }

        return response()->json([
            'leaderboard' => $leaderboard,
            'user_rank' => $userRank,
        ]);
    }
}
