<?php

namespace App\Services;

use Carbon\Carbon;
// Auth facade not used in this service
use Spatie\Activitylog\Models\Activity;
use App\Models\StudentAnswer;
use App\Models\UserTask;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Cache;

class ActivityService
{
    /**
     * Get user activity data for the contribution graph
     *
     * @param int $userId
     * @param int $months
     * @param string|null $activityType Filter by activity type (all, logins, submissions, tasks)
     * @return array
     */
    public function getUserActivityData($userId, $months = 6, $activityType = null)
    {
        // Try to get from cache first (cache for 30 minutes)
        $cacheKey = "user_activity_{$userId}_{$months}_{$activityType}";
        return Cache::remember($cacheKey, 30 * 60, function () use ($userId, $months, $activityType) {
            // Calculate the start date (X months ago from today)
            $startDate = Carbon::now()->subMonths($months)->startOfDay();
            $endDate = Carbon::now();

            // Initialize activity data array
            $activityByDate = [];
            $activityByType = [
                'logins' => [],
                'submissions' => [],
                'tasks' => [],
                'other' => []
            ];

            // Get user model
            $user = \App\Models\User::find($userId);

            // 1. Get all activities where this user is the causer (from activity log)
            $activities = Activity::where('causer_type', get_class($user))
                ->where('causer_id', $userId)
                ->where('created_at', '>=', $startDate)
                ->get();

            foreach ($activities as $activity) {
                $date = $activity->created_at->format('Y-m-d');

                if (!isset($activityByDate[$date])) {
                    $activityByDate[$date] = 0;
                    $activityByType['other'][$date] = 0;
                }

                $activityByDate[$date]++;
                $activityByType['other'][$date]++;
            }

            // 2. Get all student answers (task submissions)
            $studentAnswers = StudentAnswer::where('user_id', $userId)
                ->where('created_at', '>=', $startDate)
                ->get();

            foreach ($studentAnswers as $answer) {
                $date = $answer->created_at->format('Y-m-d');

                if (!isset($activityByDate[$date])) {
                    $activityByDate[$date] = 0;
                }
                if (!isset($activityByType['submissions'][$date])) {
                    $activityByType['submissions'][$date] = 0;
                }

                // Submissions are important activities, count them more
                $activityByDate[$date] += 2;
                $activityByType['submissions'][$date] += 1;

                // If the answer was correct, add even more weight
                if ($answer->is_correct) {
                    $activityByDate[$date] += 1;
                    $activityByType['submissions'][$date] += 1;
                }
            }

            // 3. Get all completed tasks
            $userTasks = UserTask::where('user_id', $userId)
                ->where('completed', true)
                ->where('completed_at', '>=', $startDate)
                ->get();

            foreach ($userTasks as $userTask) {
                $date = $userTask->completed_at->format('Y-m-d');

                if (!isset($activityByDate[$date])) {
                    $activityByDate[$date] = 0;
                }
                if (!isset($activityByType['tasks'][$date])) {
                    $activityByType['tasks'][$date] = 0;
                }

                // Task completions are significant achievements
                $activityByDate[$date] += 3;
                $activityByType['tasks'][$date] += 1;
            }

            // 4. Get login data
            $attendanceRecords = StudentAttendance::where('user_id', $userId)
                ->where('date', '>=', $startDate->format('Y-m-d'))
                ->get();

            foreach ($attendanceRecords as $record) {
                $date = $record->date->format('Y-m-d');

                if (!isset($activityByDate[$date])) {
                    $activityByDate[$date] = 0;
                }
                if (!isset($activityByType['logins'][$date])) {
                    $activityByType['logins'][$date] = 0;
                }

                // Add login count
                $activityByDate[$date] += min($record->login_count, 3); // Cap at 3 to prevent skewing
                $activityByType['logins'][$date] += $record->login_count;
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

            while ($currentDate <= $endDate) {
                $dateStr = $currentDate->format('Y-m-d');

                if (!isset($activityLevels[$dateStr])) {
                    $activityLevels[$dateStr] = 0;
                }

                $currentDate->addDay();
            }

            // Calculate weekly totals
            $weeklyTotals = [];
            foreach ($activityByDate as $dateStr => $count) {
                $date = new Carbon($dateStr);
                $weekStart = (clone $date)->startOfWeek()->format('Y-m-d');

                if (!isset($weeklyTotals[$weekStart])) {
                    $weeklyTotals[$weekStart] = 0;
                }

                $weeklyTotals[$weekStart] += $count;
            }

            // Calculate activity trends
            $thisWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
            $lastWeekStart = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');

            $thisWeekTotal = $weeklyTotals[$thisWeekStart] ?? 0;
            $lastWeekTotal = $weeklyTotals[$lastWeekStart] ?? 0;

            $weeklyTrend = 0;
            if ($lastWeekTotal > 0) {
                $weeklyTrend = (($thisWeekTotal - $lastWeekTotal) / $lastWeekTotal) * 100;
            } elseif ($thisWeekTotal > 0) {
                $weeklyTrend = 100; // If last week was 0 and this week has activity, that's a 100% increase
            }

            // Apply activity type filtering if specified
            $filteredActivityLevels = $activityLevels;
            $filteredActivityCounts = $activityByDate;

            if ($activityType && $activityType !== 'all' && isset($activityByType[$activityType])) {
                // Create filtered activity levels based on the selected type
                $filteredActivityLevels = [];
                $filteredActivityCounts = [];

                // Fill in all dates in the range with level 0
                $currentDate = clone $startDate;
                while ($currentDate <= $endDate) {
                    $dateStr = $currentDate->format('Y-m-d');
                    $filteredActivityLevels[$dateStr] = 0;
                    $filteredActivityCounts[$dateStr] = 0;
                    $currentDate->addDay();
                }

                // Add the filtered activity data
                foreach ($activityByType[$activityType] as $date => $count) {
                    $filteredActivityCounts[$date] = $count;

                    // Calculate level based on count
                    if ($count == 0) {
                        $filteredActivityLevels[$date] = 0;
                    } else if ($count == 1) {
                        $filteredActivityLevels[$date] = 1;
                    } else if ($count <= 3) {
                        $filteredActivityLevels[$date] = 2;
                    } else if ($count <= 5) {
                        $filteredActivityLevels[$date] = 3;
                    } else {
                        $filteredActivityLevels[$date] = 4;
                    }
                }
            }

            // Get user activity goals
            $activityGoals = $this->getUserActivityGoals($userId);

            return [
                'activity_data' => $filteredActivityLevels,
                'activity_by_type' => $activityByType,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'activity_counts' => $filteredActivityCounts,
                'weekly_totals' => $weeklyTotals,
                'weekly_trend' => round($weeklyTrend),
                'activity_type' => $activityType ?: 'all',
                'months_range' => $months,
                'activity_goals' => $activityGoals,
            ];
        });
    }

    /**
     * Generate HTML for the activity graph
     *
     * @param array $activityData
     * @return string
     */
    public function generateActivityGraphHtml($activityData)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $days = ['Mon', 'Wed', 'Fri']; // Only showing weekdays

        $startDate = new Carbon($activityData['start_date']);
        $endDate = new Carbon($activityData['end_date']);
        $activityLevels = $activityData['activity_data'];

        // Create month labels
        $monthsHTML = '<div class="flex text-xs text-gray-500 mb-1 pl-8">';

        // Calculate how many months to display
        $monthDiff = ($endDate->year - $startDate->year) * 12 + ($endDate->month - $startDate->month);
        $monthsToShow = min(6, $monthDiff + 1);

        for ($i = 0; $i < $monthsToShow; $i++) {
            $monthDate = (clone $startDate)->addMonths($i);
            $monthIndex = $monthDate->month - 1; // 0-based index
            $monthsHTML .= '<div class="flex-1 text-left">' . $months[$monthIndex] . '</div>';
        }
        $monthsHTML .= '</div>';

        // Create grid structure
        $gridHTML = '
        <div class="flex h-[calc(100%-1rem)]">
            <div class="flex flex-col w-8 text-xs text-gray-500 justify-between py-0.5 pr-2">
                <div class="h-4"></div>
                <div class="h-4">' . $days[0] . '</div>
                <div class="h-4"></div>
                <div class="h-4">' . $days[1] . '</div>
                <div class="h-4"></div>
                <div class="h-4">' . $days[2] . '</div>
                <div class="h-4"></div>
            </div>
            <div class="flex flex-1 gap-1 overflow-hidden">';

        // Calculate number of weeks to display
        $dayDiff = $startDate->diffInDays($endDate);
        $weeksToShow = ceil($dayDiff / 7);

        // Generate weeks
        $currentDate = clone $startDate;
        for ($week = 0; $week < $weeksToShow; $week++) {
            $gridHTML .= '<div class="flex flex-col gap-1 w-4">';

            // Generate 5 days per week (Mon-Fri)
            for ($day = 0; $day < 5; $day++) {
                $dateStr = $currentDate->format('Y-m-d');
                $activityLevel = $activityLevels[$dateStr] ?? 0;

                // Set color based on activity level
                $bgColor = 'bg-neutral-700'; // Default: No activity
                if ($activityLevel === 1) $bgColor = 'bg-emerald-900';
                if ($activityLevel === 2) $bgColor = 'bg-emerald-700';
                if ($activityLevel === 3) $bgColor = 'bg-emerald-500';
                if ($activityLevel >= 4) $bgColor = 'bg-emerald-300';

                // Add tooltip with date and activity count
                $dateDisplay = $currentDate->format('M j, Y');
                $activityTitle = $activityLevel === 0 ? 'No activity' :
                                ($activityLevel === 1 ? 'Low activity' :
                                ($activityLevel === 2 ? 'Medium activity' :
                                ($activityLevel === 3 ? 'High activity' : 'Very high activity')));

                // Simple activity square without tooltip
                $gridHTML .= '<div class="h-4 w-4 rounded-sm ' . $bgColor . '" title="' . $dateDisplay . ': ' . $activityTitle . '"></div>';

                // Move to next day
                $currentDate->addDay();
            }

            $gridHTML .= '</div>';
        }

        $gridHTML .= '</div></div>';

        return $monthsHTML . $gridHTML;
    }

    /**
     * Generate HTML for weekly activity summary with integrated activity goals
     *
     * @param array $activityData
     * @param string|null $activityGoalsHtml Optional pre-generated activity goals HTML
     * @return string
     */
    public function generateWeeklySummaryHtml($activityData, $activityGoalsHtml = null)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $weeklyTotals = $activityData['weekly_totals'];

        // Sort weeks chronologically
        ksort($weeklyTotals);

        // Get the most recent 6 weeks
        $recentWeeks = array_slice($weeklyTotals, -6, 6, true);

        // Start with a container div
        $html = '<div class="space-y-3">';

        // Weekly summary section
        $html .= '<div class="flex justify-between text-xs text-gray-400">';

        foreach ($recentWeeks as $weekStart => $total) {
            $weekStartDate = new Carbon($weekStart);
            $weekEndDate = (clone $weekStartDate)->addDays(6);

            $dateRange = $weekStartDate->format('j') . ' ' . $months[$weekStartDate->month - 1];
            if ($weekStartDate->month != $weekEndDate->month) {
                $dateRange .= ' - ' . $weekEndDate->format('j') . ' ' . $months[$weekEndDate->month - 1];
            } else {
                $dateRange .= ' - ' . $weekEndDate->format('j');
            }

            $html .= '
            <div class="text-center">
                <div class="font-medium">' . $total . '</div>
                <div class="text-gray-500">' . $dateRange . '</div>
            </div>';
        }

        $html .= '</div>';

        // Add activity goals section if provided
        if ($activityGoalsHtml !== null) {
            // Just include the entire activity goals HTML as is
            // This preserves all the styling and structure
            $html .= $activityGoalsHtml;
        }

        // Close the container div
        $html .= '</div>';

        return $html;
    }

    /**
     * Generate HTML for activity trend indicator
     *
     * @param array $activityData
     * @return string
     */
    public function generateTrendIndicatorHtml($activityData)
    {
        $trend = $activityData['weekly_trend'];

        $trendClass = 'text-gray-400';
        $trendIcon = '';

        if ($trend > 0) {
            $trendClass = 'text-emerald-400';
            $trendIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
            </svg>';
        } elseif ($trend < 0) {
            $trendClass = 'text-red-400';
            $trendIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
            </svg>';
        } else {
            $trendIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>';
        }

        $html = '<div class="flex items-center gap-2 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 shadow-inner">
            <div class="text-xs text-gray-400">This week:</div>
            <div class="text-sm font-medium ' . $trendClass . ' flex items-center">
                ' . $trendIcon . '
                ' . abs($trend) . '% ' . ($trend >= 0 ? 'vs' : 'below') . ' last week
            </div>
        </div>';

        return $html;
    }

    /**
     * Get user activity goals
     *
     * @param int $userId
     * @return array
     */
    public function getUserActivityGoals($userId)
    {
        // Get ALL goals from the database (both active and completed)
        $allGoals = \App\Models\ActivityGoal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active goals only for display
        $goals = $allGoals->where('is_active', true);

        // Get the total count of all goals
        $totalGoalsCount = $allGoals->count();

        // Format goals for the dashboard
        $formattedGoals = [];

        // Check if we have any custom goals at all
        $hasCustomGoals = $totalGoalsCount > 0;

        foreach ($goals as $goal) {
            $type = $goal->goal_type;
            $current = $goal->getCurrentProgress();

            $formattedGoals[$type] = [
                'id' => $goal->id,
                'title' => $goal->title,
                'target' => $goal->target_value,
                'current' => $current,
                'is_completed' => $goal->is_completed,
                'percentage' => $goal->getProgressPercentage(),
                'period_type' => $goal->period_type,
                'is_custom' => true,
            ];
        }

        // Add default goals only if no custom goals exist
        if (!$hasCustomGoals) {
            $formattedGoals['daily'] = [
                'target' => 5,
                'current' => $this->getCurrentDayActivityCount($userId),
                'is_default' => true,
            ];

            $formattedGoals['weekly'] = [
                'target' => 25,
                'current' => $this->getCurrentWeekActivityCount($userId),
                'is_default' => true,
            ];
        }

        return [
            'goals' => $formattedGoals,
            'has_custom_goals' => $hasCustomGoals,
            'total_goals_count' => $totalGoalsCount,
        ];
    }

    /**
     * Get current day's activity count
     *
     * @param int $userId
     * @return int
     */
    public function getCurrentDayActivityCount($userId)
    {
        $today = Carbon::now()->format('Y-m-d');

        // Direct database query to avoid recursion
        $count = 0;

        // Count activities
        $activities = Activity::where('causer_type', '\\App\\Models\\User')
            ->where('causer_id', $userId)
            ->whereDate('created_at', $today)
            ->count();
        $count += $activities;

        // Count submissions
        $submissions = StudentAnswer::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->count();
        $count += $submissions * 2;

        // Count completed tasks
        $tasks = UserTask::where('user_id', $userId)
            ->where('completed', true)
            ->whereDate('completed_at', $today)
            ->count();
        $count += $tasks * 3;

        // Count logins
        $logins = StudentAttendance::where('user_id', $userId)
            ->where('date', $today)
            ->value('login_count') ?? 0;
        $count += min($logins, 3);

        return $count;
    }

    /**
     * Get current week's activity count
     *
     * @param int $userId
     * @return int
     */
    public function getCurrentWeekActivityCount($userId)
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Direct database query to avoid recursion
        $count = 0;

        // Count activities
        $activities = Activity::where('causer_type', '\\App\\Models\\User')
            ->where('causer_id', $userId)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();
        $count += $activities;

        // Count submissions
        $submissions = StudentAnswer::where('user_id', $userId)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();
        $count += $submissions * 2;

        // Count completed tasks
        $tasks = UserTask::where('user_id', $userId)
            ->where('completed', true)
            ->whereBetween('completed_at', [$weekStart, $weekEnd])
            ->count();
        $count += $tasks * 3;

        // Count logins
        $logins = StudentAttendance::where('user_id', $userId)
            ->whereBetween('date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
            ->sum('login_count');
        $count += min($logins, 3 * 7); // Cap at 3 per day for a week

        return $count;
    }

    /**
     * Generate HTML for activity goals
     *
     * @param array $activityData
     * @return string
     */
    public function generateActivityGoalsHtml($activityData)
    {
        $goalData = $activityData['activity_goals'];
        $goals = $goalData['goals'];
        $hasCustomGoals = $goalData['has_custom_goals'];
        $totalGoalsCount = $goalData['total_goals_count'];

        $html = '<div class="mt-3 bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-2">';
        // Compact header with minimal spacing
        $html .= '<div class="flex justify-between items-center mb-2">';

        // Simplified title section
        $html .= '<div class="flex items-center gap-1 max-w-[70%]">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />';
        $html .= '<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= '<span class="text-sm font-medium text-white">Activity Goals</span>';
        $html .= '</div>';

        // Standard button matching dashboard style
        $html .= '<a href="' . route('goals.create') . '" class="text-xs px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full transition-colors duration-200 flex items-center gap-1 whitespace-nowrap flex-shrink-0">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= 'Create Goal</a>';
        $html .= '</div>';

        // No goals message - standard dashboard style (without duplicate button)
        if ($totalGoalsCount === 0) {
            $html .= '<div class="py-4 text-center">';
            $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-neutral-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
            $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />';
            $html .= '</svg>';
            $html .= '<p class="text-neutral-400 text-sm">You haven\'t created any activity goals yet.</p>';
            $html .= '<p class="text-neutral-400 text-xs">Use the "Create Goal" button above to get started.</p>';
            $html .= '</div>';

            // Display default goals - standard dashboard style
            $html .= '<div class="mt-4 pt-4 border-t border-neutral-700/50">';
            $html .= '<h5 class="text-xs font-medium text-neutral-400 mb-3">Suggested Goals</h5>';

            $dailyPercentage = min(100, round(($goals['daily']['current'] / max(1, $goals['daily']['target'])) * 100));
            $html .= '<div class="mb-4">';
            $html .= '<div class="flex justify-between items-center mb-2">';
            $html .= '<span class="text-sm text-gray-300">Daily Activity Goal</span>';
            $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['daily']['current'] . ' / ' . $goals['daily']['target'] . ' activities</span>';
            $html .= '</div>';
            $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
            $html .= '<div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: ' . $dailyPercentage . '%"></div>';
            $html .= '</div>';
            $html .= '</div>';

            $weeklyPercentage = min(100, round(($goals['weekly']['current'] / max(1, $goals['weekly']['target'])) * 100));
            $html .= '<div>';
            $html .= '<div class="flex justify-between items-center mb-2">';
            $html .= '<span class="text-sm text-gray-300">Weekly Activity Goal</span>';
            $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['weekly']['current'] . ' / ' . $goals['weekly']['target'] . ' activities</span>';
            $html .= '</div>';
            $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
            $html .= '<div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full" style="width: ' . $weeklyPercentage . '%"></div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        } else {
            // Display custom goals
            if ($hasCustomGoals) {
                $goalCount = 0;
                $activeGoals = [];
                $completedGoals = [];

                // Separate active and completed goals
                foreach ($goals as $type => $goal) {
                    if (isset($goal['is_default'])) continue; // Skip default goals
                    if (!isset($goal['is_custom'])) continue; // Skip non-custom goals

                    if (isset($goal['is_completed']) && $goal['is_completed']) {
                        $completedGoals[$type] = $goal;
                    } else {
                        $activeGoals[$type] = $goal;
                    }
                }

                // Display active goals first
                foreach ($activeGoals as $type => $goal) {
                    $percentage = $goal['percentage'] ?? min(100, round(($goal['current'] / max(1, $goal['target'])) * 100));
                    $bgColor = 'from-emerald-500 to-teal-400';

                    // Different colors for different goal types
                    if ($type === 'login_streak') $bgColor = 'from-blue-500 to-cyan-400';
                    if ($type === 'tasks_completed') $bgColor = 'from-purple-500 to-indigo-400';
                    if ($type === 'challenges_completed') $bgColor = 'from-orange-500 to-amber-400';
                    if ($type === 'experience_points') $bgColor = 'from-pink-500 to-rose-400';

                    $html .= '<div class="' . ($goalCount > 0 ? 'mt-4' : '') . '">';
                    $html .= '<div class="flex justify-between items-center mb-2">';
                    $html .= '<div class="flex items-center gap-2 max-w-[70%]">';
                    $html .= '<span class="text-sm text-gray-300 truncate">' . $goal['title'] . '</span>';

                    // Period badge - standard
                    if (isset($goal['period_type']) && $goal['period_type'] !== 'all_time') {
                        $html .= '<span class="text-xs px-2 py-0.5 bg-neutral-700/50 text-neutral-400 rounded-full">' . ucfirst($goal['period_type']) . '</span>';
                    }

                    $html .= '</div>';
                    $html .= '<span class="text-sm text-gray-300 font-medium">' . $goal['current'] . ' / ' . $goal['target'] . '</span>';
                    $html .= '</div>';
                    $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                    $html .= '<div class="h-full bg-gradient-to-r ' . $bgColor . ' rounded-full" style="width: ' . $percentage . '%"></div>';
                    $html .= '</div>';
                    $html .= '</div>';

                    $goalCount++;
                }

                // Display completed goals if there's space
                if ($goalCount < 2 && !empty($completedGoals)) {
                    foreach ($completedGoals as $type => $goal) {
                        if ($goalCount >= 2) break; // Only show up to 2 goals

                        $html .= '<div class="mt-4">';
                        $html .= '<div class="flex justify-between items-center mb-2">';
                        $html .= '<div class="flex items-center gap-2 max-w-[70%]">';
                        $html .= '<span class="text-sm text-gray-300 truncate">' . $goal['title'] . '</span>';
                        $html .= '<span class="text-xs px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-full">Completed</span>';
                        $html .= '</div>';
                        $html .= '<span class="text-sm text-gray-300 font-medium">' . $goal['current'] . ' / ' . $goal['target'] . '</span>';
                        $html .= '</div>';
                        $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                        $html .= '<div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: 100%"></div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        $goalCount++;
                    }
                }

                // If we have no custom goals at all, add default ones
                if ($goalCount === 0 && !$hasCustomGoals) {
                    // Add default goals
                    if (isset($goals['daily']) && $goals['daily']['is_default'] ?? false) {
                        $dailyPercentage = min(100, round(($goals['daily']['current'] / max(1, $goals['daily']['target'])) * 100));
                        $html .= '<div class="' . ($goalCount > 0 ? 'mt-4' : '') . '">';
                        $html .= '<div class="flex justify-between items-center mb-2">';
                        $html .= '<div class="flex items-center gap-2">';
                        $html .= '<span class="text-sm text-gray-300">Daily Activity Goal</span>';
                        $html .= '<span class="text-xs px-2 py-0.5 bg-neutral-700/50 text-neutral-400 rounded-full">Suggested</span>';
                        $html .= '</div>';
                        $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['daily']['current'] . ' / ' . $goals['daily']['target'] . ' activities</span>';
                        $html .= '</div>';
                        $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                        $html .= '<div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: ' . $dailyPercentage . '%"></div>';
                        $html .= '</div>';
                        $html .= '</div>';

                        $goalCount++;
                    }

                    if (isset($goals['weekly']) && $goals['weekly']['is_default'] ?? false) {
                        $weeklyPercentage = min(100, round(($goals['weekly']['current'] / max(1, $goals['weekly']['target'])) * 100));
                        $html .= '<div class="mt-4">';
                        $html .= '<div class="flex justify-between items-center mb-2">';
                        $html .= '<div class="flex items-center gap-2">';
                        $html .= '<span class="text-sm text-gray-300">Weekly Activity Goal</span>';
                        $html .= '<span class="text-xs px-2 py-0.5 bg-neutral-700/50 text-neutral-400 rounded-full">Suggested</span>';
                        $html .= '</div>';
                        $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['weekly']['current'] . ' / ' . $goals['weekly']['target'] . ' activities</span>';
                        $html .= '</div>';
                        $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                        $html .= '<div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full" style="width: ' . $weeklyPercentage . '%"></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
            } else if ($totalGoalsCount === 0) {
                // Only display default goals if the user has no goals at all
                $dailyPercentage = min(100, round(($goals['daily']['current'] / max(1, $goals['daily']['target'])) * 100));
                $html .= '<div class="mb-4">';
                $html .= '<div class="flex justify-between items-center mb-2">';
                $html .= '<span class="text-sm text-gray-300">Daily Activity Goal</span>';
                $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['daily']['current'] . ' / ' . $goals['daily']['target'] . ' activities</span>';
                $html .= '</div>';
                $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                $html .= '<div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: ' . $dailyPercentage . '%"></div>';
                $html .= '</div>';
                $html .= '</div>';

                $weeklyPercentage = min(100, round(($goals['weekly']['current'] / max(1, $goals['weekly']['target'])) * 100));
                $html .= '<div>';
                $html .= '<div class="flex justify-between items-center mb-2">';
                $html .= '<span class="text-sm text-gray-300">Weekly Activity Goal</span>';
                $html .= '<span class="text-sm text-gray-300 font-medium">' . $goals['weekly']['current'] . ' / ' . $goals['weekly']['target'] . ' activities</span>';
                $html .= '</div>';
                $html .= '<div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">';
                $html .= '<div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full" style="width: ' . $weeklyPercentage . '%"></div>';
                $html .= '</div>';
                $html .= '</div>';
            } else {
                // If user has goals but none are active to display, show a message
                $html .= '<div class="py-4 text-center">';
                $html .= '<p class="text-neutral-400 mb-2">All your goals are completed.</p>';
                $html .= '<a href="' . route('goals.create') . '" class="text-xs px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200 inline-flex items-center gap-1">';
                $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">';
                $html .= '<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />';
                $html .= '</svg>';
                $html .= 'Create New Goal</a>';
                $html .= '</div>';
            }
        }

        // View All Goals link - standard dashboard style
        $html .= '<div class="mt-4 text-center">';
        $html .= '<a href="' . route('goals.index') . '" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors duration-200">View All Goals</a>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}
