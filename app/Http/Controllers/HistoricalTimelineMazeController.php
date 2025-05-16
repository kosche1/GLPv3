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
