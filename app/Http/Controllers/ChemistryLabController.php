<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ChemistryChallenge;
use App\Models\UserChemistryAttempt;

class ChemistryLabController extends Controller
{
    /**
     * Display the chemistry lab simulator.
     */
    public function index(): View
    {
        // Get active chemistry challenges
        $challenges = ChemistryChallenge::where('is_active', true)
            ->orderBy('difficulty_level', 'asc')
            ->get();

        // Get user's completed challenges
        $completedChallenges = [];
        if (Auth::check()) {
            $userId = Auth::id();
            $completedChallenges = UserChemistryAttempt::where('user_id', $userId)
                ->where('status', 'approved')
                ->pluck('chemistry_challenge_id')
                ->toArray();
        }

        return view('chemistry-lab.index', [
            'challenges' => $challenges,
            'completedChallenges' => $completedChallenges,
        ]);
    }

    /**
     * Display a specific chemistry challenge.
     */
    public function showChallenge(ChemistryChallenge $challenge): View
    {
        return view('chemistry-lab.challenge', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * Display the free experimentation lab.
     */
    public function freeExperiment(): View
    {
        return view('chemistry-lab.free-experiment');
    }

    /**
     * Submit a challenge attempt.
     */
    public function submitChallenge(Request $request, ChemistryChallenge $challenge)
    {
        $validated = $request->validate([
            'solution_data' => 'required|json',
            'notes' => 'nullable|string',
        ]);

        // Create or update user attempt
        $attempt = UserChemistryAttempt::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'chemistry_challenge_id' => $challenge->id,
            ],
            [
                'user_solution' => $validated['solution_data'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending', // Requires teacher review
                'submitted_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Your solution has been submitted for review.',
            'attempt_id' => $attempt->id,
        ]);
    }
}
