<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use App\Models\StudentAnswer;
use App\Models\UserTask;

class ActivityController extends Controller
{
    /**
     * Get user activity data for the contribution graph
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserActivityData(Request $request)
    {
        $user = Auth::user();
        $months = $request->input('months', 6); // Default to 6 months of data

        // Calculate the start date (X months ago from today)
        $startDate = Carbon::now()->subMonths($months)->startOfDay();

        // Initialize activity data array
        $activityByDate = [];

        // 1. Get all activities where this user is the causer (from activity log)
        $activities = Activity::where('causer_type', get_class($user))
            ->where('causer_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->get();

        foreach ($activities as $activity) {
            $date = $activity->created_at->format('Y-m-d');

            if (!isset($activityByDate[$date])) {
                $activityByDate[$date] = 0;
            }

            $activityByDate[$date]++;
        }

        // 2. Get all student answers (task submissions)
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->get();

        foreach ($studentAnswers as $answer) {
            $date = $answer->created_at->format('Y-m-d');

            if (!isset($activityByDate[$date])) {
                $activityByDate[$date] = 0;
            }

            // Submissions are important activities, count them more
            $activityByDate[$date] += 2;

            // If the answer was correct, add even more weight
            if ($answer->is_correct) {
                $activityByDate[$date] += 1;
            }
        }

        // 3. Get all completed tasks
        $userTasks = UserTask::where('user_id', $user->id)
            ->where('completed', true)
            ->where('completed_at', '>=', $startDate)
            ->get();

        foreach ($userTasks as $userTask) {
            $date = $userTask->completed_at->format('Y-m-d');

            if (!isset($activityByDate[$date])) {
                $activityByDate[$date] = 0;
            }

            // Task completions are significant achievements
            $activityByDate[$date] += 3;
        }

        // Calculate activity levels (0-4) based on the number of activities per day
        $activityLevels = [];

        if (count($activityByDate) > 0) {
            // Find the maximum number of activities in a day
            $maxActivities = max($activityByDate);

            // Ensure we have a reasonable minimum for max activities
            $maxActivities = max($maxActivities, 5);

            foreach ($activityByDate as $date => $count) {
                // Calculate level based on percentage of max activity
                // Level 0: 0 activities
                // Level 1: 1-25% of max
                // Level 2: 26-50% of max
                // Level 3: 51-75% of max
                // Level 4: 76-100% of max

                if ($count == 0) {
                    $level = 0;
                } else if ($maxActivities <= 4) {
                    // If max is small, just use the count directly (1-4)
                    $level = min($count, 4);
                } else {
                    $percentage = ($count / $maxActivities) * 100;

                    if ($percentage <= 25) {
                        $level = 1;
                    } else if ($percentage <= 50) {
                        $level = 2;
                    } else if ($percentage <= 75) {
                        $level = 3;
                    } else {
                        $level = 4;
                    }
                }

                $activityLevels[$date] = $level;
            }
        }

        // Fill in all dates in the range with level 0 if no activity
        $currentDate = clone $startDate;
        $endDate = Carbon::now();

        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');

            if (!isset($activityLevels[$dateStr])) {
                $activityLevels[$dateStr] = 0;
            }

            $currentDate->addDay();
        }

        // Return the data
        return response()->json([
            'activity_data' => $activityLevels,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'activity_counts' => $activityByDate, // Include raw counts for debugging
        ]);
    }
}
