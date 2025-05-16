<?php

namespace App\Http\Controllers;

use App\Models\EquationDrop;
use Illuminate\Http\Request;
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
    public function saveScore(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'difficulty' => 'required|string',
            'completed' => 'required|boolean',
        ]);

        // In a production environment, you would save this to a database
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'Score saved successfully',
        ]);
    }
}