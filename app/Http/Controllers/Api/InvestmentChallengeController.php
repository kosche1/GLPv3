<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InvestmentChallenge;
use App\Models\UserInvestmentChallenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InvestmentChallengeController extends Controller
{
    /**
     * Get all available challenges
     */
    public function index()
    {
        try {
            $challenges = InvestmentChallenge::where('is_active', true)->get();

            // Log the number of challenges found
            Log::info('Fetched investment challenges: ' . $challenges->count());

            return response()->json($challenges);
        } catch (\Exception $e) {
            Log::error('Error fetching investment challenges: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get user's challenges (in progress, completed, etc.)
     */
    public function userChallenges()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Log authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in userChallenges:', [
            'is_authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
        ]);

        // If no user is authenticated, return empty array
        if (!$user) {
            return response()->json([]);
        }

        $userChallenges = UserInvestmentChallenge::with('challenge')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($userChallenge) {
                $challenge = $userChallenge->challenge;
                return [
                    'id' => $userChallenge->id,
                    'challenge_id' => $challenge->id,
                    'title' => $challenge->title,
                    'description' => $challenge->description,
                    'difficulty' => $challenge->difficulty,
                    'duration' => $challenge->duration,
                    'points' => $challenge->points,
                    'status' => $userChallenge->status,
                    'progress' => $userChallenge->progress,
                    'start_date' => $userChallenge->start_date,
                    'end_date' => $userChallenge->end_date,
                    'days_remaining' => $userChallenge->days_remaining,
                    'submitted_at' => $userChallenge->submitted_at,
                    'grade' => $userChallenge->grade,
                    'feedback' => $userChallenge->feedback
                ];
            });

        return response()->json($userChallenges);
    }

    /**
     * Start a new challenge
     */
    public function startChallenge(Request $request)
    {
        $request->validate([
            'challenge_id' => 'required|exists:investment_challenges,id'
        ]);

        $challenge = InvestmentChallenge::findOrFail($request->challenge_id);

        // Get the authenticated user
        $user = Auth::user();

        // Log authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in startChallenge:', [
            'is_authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
        ]);

        // Old code for temporary challenges - no longer used
        if (false) {
            $startDate = Carbon::now();
            $endDate = Carbon::now()->addDays($challenge->duration);

            // Create a temporary challenge object (not saved to database)
            $tempChallenge = [
                'id' => 'temp_' . $challenge->id,
                'challenge_id' => $challenge->id,
                'title' => $challenge->title,
                'description' => $challenge->description,
                'difficulty' => $challenge->difficulty,
                'duration' => $challenge->duration,
                'points' => $challenge->points,
                'status' => 'in-progress',
                'progress' => 0,
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
                'days_remaining' => $challenge->duration,
                'is_temp' => true
            ];

            return response()->json([
                'message' => 'Challenge started in temporary mode (not logged in)',
                'challenge' => $tempChallenge
            ]);
        }

        // Check if user already has this challenge in progress
        $existingChallenge = UserInvestmentChallenge::where('user_id', $user->id)
            ->where('investment_challenge_id', $challenge->id)
            ->first();

        if ($existingChallenge) {
            return response()->json([
                'message' => 'You have already started this challenge',
                'challenge' => $existingChallenge
            ], 400);
        }

        // Create new user challenge
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays($challenge->duration);

        $userChallenge = UserInvestmentChallenge::create([
            'user_id' => $user->id,
            'investment_challenge_id' => $challenge->id,
            'status' => 'in-progress',
            'progress' => 0,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        return response()->json([
            'message' => 'Challenge started successfully',
            'challenge' => $userChallenge->load('challenge')
        ]);
    }

    /**
     * Update challenge progress
     */
    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Log authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in updateProgress:', [
            'is_authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
        ]);

        // If no user is authenticated, return error
        if (!$user) {
            return response()->json([
                'message' => 'You must be logged in to update challenge progress'
            ], 401);
        }

        $userChallenge = UserInvestmentChallenge::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $userChallenge->progress = $request->progress;

        if ($request->progress >= 100) {
            $userChallenge->status = 'completed';
        }

        $userChallenge->save();

        return response()->json([
            'message' => 'Challenge progress updated',
            'challenge' => $userChallenge->load('challenge')
        ]);
    }

    /**
     * Submit a completed challenge
     */
    public function submitChallenge(Request $request, $id)
    {
        $request->validate([
            'strategy' => 'required|string',
            'learnings' => 'required|string'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Log authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in submitChallenge:', [
            'is_authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
        ]);

        // If no user is authenticated, return error
        if (!$user) {
            return response()->json([
                'message' => 'You must be logged in to submit a challenge'
            ], 401);
        }

        $userChallenge = UserInvestmentChallenge::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($userChallenge->status !== 'completed') {
            return response()->json([
                'message' => 'Challenge must be completed before submitting'
            ], 400);
        }

        $userChallenge->strategy = $request->strategy;
        $userChallenge->learnings = $request->learnings;
        $userChallenge->status = 'submitted';
        $userChallenge->submitted_at = Carbon::now();
        $userChallenge->save();

        return response()->json([
            'message' => 'Challenge submitted successfully',
            'challenge' => $userChallenge->load('challenge')
        ]);
    }

    /**
     * Delete a user challenge (to restart it)
     */
    public function deleteChallenge($id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Log authentication status
        \Illuminate\Support\Facades\Log::info('User authentication status in deleteChallenge:', [
            'is_authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
        ]);

        // If no user is authenticated, return error
        if (!$user) {
            return response()->json([
                'message' => 'You must be logged in to delete a challenge'
            ], 401);
        }

        $userChallenge = UserInvestmentChallenge::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Store challenge info before deleting
        $challengeInfo = [
            'title' => $userChallenge->challenge->title,
            'id' => $userChallenge->challenge->id
        ];

        // Delete the challenge
        $userChallenge->delete();

        return response()->json([
            'message' => 'Challenge deleted successfully. You can now restart it.',
            'challenge_info' => $challengeInfo
        ]);
    }
}
