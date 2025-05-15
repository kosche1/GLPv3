<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\HistoricalTimelineMaze;
use App\Models\HistoricalTimelineMazeQuestion;

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
     * Save user's game progress and score.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveProgress(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'level_completed' => 'required|string',
            'time_taken' => 'required|integer',
        ]);

        // In a production environment, you would save this to a database
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'Progress saved successfully',
        ]);
    }
}
