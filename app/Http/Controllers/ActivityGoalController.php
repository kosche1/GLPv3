<?php

namespace App\Http\Controllers;

use App\Models\ActivityGoal;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityGoalController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the user's goals.
     */
    public function index()
    {
        $user = Auth::user();
        $goals = ActivityGoal::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Update goal completion status
        foreach ($goals as $goal) {
            $goal->checkCompletion();
        }

        return view('goals.index', [
            'goals' => $goals,
        ]);
    }

    /**
     * Show the form for creating a new goal.
     */
    public function create()
    {
        return view('goals.create');
    }

    /**
     * Store a newly created goal in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_type' => 'required|string|in:login_streak,daily_activity,weekly_activity,tasks_completed,challenges_completed,experience_points',
            'target_value' => 'required|integer|min:1',
            'period_type' => 'required|string|in:daily,weekly,monthly,custom,all_time',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        // Set default dates based on period type
        if ($validated['period_type'] === 'all_time') {
            // For 'all_time', explicitly set both dates to null
            $validated['start_date'] = null;
            $validated['end_date'] = null;
        } elseif ($validated['period_type'] !== 'custom') {
            // For daily, weekly, monthly, set appropriate dates
            $validated['start_date'] = Carbon::now()->startOfDay();

            switch ($validated['period_type']) {
                case 'daily':
                    $validated['end_date'] = Carbon::now()->endOfDay();
                    break;
                case 'weekly':
                    $validated['end_date'] = Carbon::now()->endOfWeek();
                    break;
                case 'monthly':
                    $validated['end_date'] = Carbon::now()->endOfMonth();
                    break;
            }
        }

        // Create the goal
        $goal = new ActivityGoal($validated);
        $goal->user_id = $user->id;
        $goal->save();

        return redirect()->route('goals.index')
            ->with('success', 'Goal created successfully!');
    }

    /**
     * Display the specified goal.
     */
    public function show(ActivityGoal $goal)
    {
        // Check if the goal belongs to the authenticated user
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update goal completion status
        $goal->checkCompletion();

        return view('goals.show', [
            'goal' => $goal,
        ]);
    }

    /**
     * Show the form for editing the specified goal.
     */
    public function edit(ActivityGoal $goal)
    {
        // Check if the goal belongs to the authenticated user
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('goals.edit', [
            'goal' => $goal,
        ]);
    }

    /**
     * Update the specified goal in storage.
     */
    public function update(Request $request, ActivityGoal $goal)
    {
        // Check if the goal belongs to the authenticated user
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_value' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.index')
            ->with('success', 'Goal updated successfully!');
    }

    /**
     * Remove the specified goal from storage.
     */
    public function destroy(ActivityGoal $goal)
    {
        // Check if the goal belongs to the authenticated user
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully!');
    }

    /**
     * Mark a goal as completed.
     */
    public function complete(ActivityGoal $goal)
    {
        // Check if the goal belongs to the authenticated user
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $goal->is_completed = true;
        $goal->completed_at = Carbon::now();
        $goal->save();

        return redirect()->route('goals.index')
            ->with('success', 'Goal marked as completed!');
    }

    /**
     * Get the user's active goals for the dashboard.
     */
    public function getActiveGoals()
    {
        $user = Auth::user();
        $goals = ActivityGoal::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->take(2) // Get only the 2 most recent goals for the dashboard
            ->get();

        $formattedGoals = [];

        foreach ($goals as $goal) {
            $formattedGoals[] = [
                'id' => $goal->id,
                'title' => $goal->title,
                'target' => $goal->target_value,
                'current' => $goal->getCurrentProgress(),
                'percentage' => $goal->getProgressPercentage(),
                'type' => $goal->goal_type,
                'period' => $goal->period_type,
            ];
        }

        return response()->json($formattedGoals);
    }
}
