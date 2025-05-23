<?php

namespace App\Http\Controllers;

use App\Models\EquationDrop;
use App\Models\EquationDropResult;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EquationDropController extends Controller
{
    /**
     * Display the equation drop game page.
     */
    public function index(): View
    {
        // Get the active Equation Drop game with questions
        $equationDrop = EquationDrop::where('is_active', true)
            ->with(['easyQuestions', 'mediumQuestions', 'hardQuestions'])
            ->first();

        // Data for the Equation Drop game
        $data = [
            'trackName' => 'STEM',
            'pageTitle' => 'Equation Drop',
            'equationDrop' => $equationDrop
        ];

        return view('equation-drop.index', $data);
    }

    /**
     * Get questions for the Equation Drop game.
     */
    public function getQuestions(Request $request)
    {
        // Get the active Equation Drop game
        $equationDrop = EquationDrop::where('is_active', true)->first();

        if (!$equationDrop) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        // Get questions by difficulty
        $difficulty = $request->input('difficulty', 'easy');

        switch ($difficulty) {
            case 'easy':
                $questions = $equationDrop->easyQuestions()->get();
                break;
            case 'medium':
                $questions = $equationDrop->mediumQuestions()->get();
                break;
            case 'hard':
                $questions = $equationDrop->hardQuestions()->get();
                break;
            default:
                $questions = $equationDrop->easyQuestions()->get();
        }

        // Include timer settings for the selected difficulty
        $timerSettings = [
            'easy_timer_seconds' => $equationDrop->easy_timer_seconds ?? 60,
            'medium_timer_seconds' => $equationDrop->medium_timer_seconds ?? 45,
            'hard_timer_seconds' => $equationDrop->hard_timer_seconds ?? 30,
        ];

        return response()->json([
            'questions' => $questions,
            'timer_settings' => $timerSettings
        ]);
    }

    /**
     * Save a user's game score.
     */
    public function saveScore(Request $request): JsonResponse
    {
        $request->validate([
            'score' => 'required|integer',
            'difficulty' => 'required|string',
            'completed' => 'required|boolean',
            'questions_attempted' => 'required|integer',
            'questions_correct' => 'required|integer',
            'time_spent_seconds' => 'required|integer',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the active Equation Drop game
        $equationDrop = EquationDrop::where('is_active', true)->first();

        if (!$equationDrop) {
            return response()->json([
                'success' => false,
                'message' => 'No active equation drop game found',
            ], 404);
        }

        // Calculate accuracy percentage
        $questionsAttempted = $request->input('questions_attempted');
        $questionsCorrect = $request->input('questions_correct');
        $accuracyPercentage = $questionsAttempted > 0
            ? ($questionsCorrect / $questionsAttempted) * 100
            : 0;

        // Create the result record
        $result = new EquationDropResult([
            'user_id' => Auth::id(),
            'equation_drop_id' => $equationDrop->id,
            'difficulty' => $request->input('difficulty'),
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
            'message' => 'Score saved successfully',
            'result' => $result,
        ]);
    }

    /**
     * Get the user's equation drop results history.
     */
    public function getResults(): JsonResponse
    {
        $user = Auth::user();

        // Get results ordered by date (newest first)
        $results = EquationDropResult::where('user_id', $user->id)
            ->with('equationDrop:id,title')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($results);
    }
}