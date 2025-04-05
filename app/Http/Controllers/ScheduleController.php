<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Display the schedule with tasks for the current week.
     */
    public function index(Request $request): View
    {
        // Determine view type (weekly or monthly)
        $viewType = $request->input('view', 'weekly');

        if ($viewType === 'weekly') {
            return $this->weeklyView($request);
        } else {
            return $this->monthlyView($request);
        }
    }

    /**
     * Display the weekly schedule view.
     */
    private function weeklyView(Request $request): View
    {
        // Get the week start date from the request or use current week
        $weekStart = $this->getWeekStartDate($request);
        $weekEnd = (clone $weekStart)->addDays(6);

        // Get user's tasks from the user_tasks pivot table
        $user = User::find(Auth::id());
        $userTasks = $user ? $user->tasks()->with('challenge')->get() : collect();

        // Get active challenges with their tasks
        $challenges = Challenge::with('tasks')
            ->where('is_active', true)
            ->where(function($query) use ($weekStart, $weekEnd) {
                $query->where(function($q) use ($weekStart, $weekEnd) {
                    // Challenges that start or end during this week
                    $q->whereBetween('start_date', [$weekStart, $weekEnd])
                      ->orWhereBetween('end_date', [$weekStart, $weekEnd]);
                })->orWhere(function($q) use ($weekStart, $weekEnd) {
                    // Challenges that span this week
                    $q->where('start_date', '<', $weekStart)
                      ->where('end_date', '>', $weekEnd);
                });
            })
            ->get();

        // Organize tasks by day of the week
        $weekDays = $this->generateWeekDays($weekStart);
        $tasksByDay = $this->organizeTasksByDay($userTasks, $challenges, $weekDays);

        // Return the view with the data
        return view('schedule', [
            'viewType' => 'weekly',
            'weekDays' => $weekDays,
            'tasksByDay' => $tasksByDay,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'previousWeek' => (clone $weekStart)->subDays(7)->format('Y-m-d'),
            'nextWeek' => (clone $weekStart)->addDays(7)->format('Y-m-d'),
        ]);
    }

    /**
     * Display the monthly schedule view.
     */
    private function monthlyView(Request $request): View
    {
        // Get the month start date from the request or use current month
        $monthStart = $this->getMonthStartDate($request);
        $monthEnd = (clone $monthStart)->endOfMonth();

        // Get user's tasks from the user_tasks pivot table
        $user = User::find(Auth::id());
        $userTasks = $user ? $user->tasks()->with('challenge')->get() : collect();

        // Get active challenges with their tasks
        $challenges = Challenge::with('tasks')
            ->where('is_active', true)
            ->where(function($query) use ($monthStart, $monthEnd) {
                $query->where(function($q) use ($monthStart, $monthEnd) {
                    // Challenges that start or end during this month
                    $q->whereBetween('start_date', [$monthStart, $monthEnd])
                      ->orWhereBetween('end_date', [$monthStart, $monthEnd]);
                })->orWhere(function($q) use ($monthStart, $monthEnd) {
                    // Challenges that span this month
                    $q->where('start_date', '<', $monthStart)
                      ->where('end_date', '>', $monthEnd);
                });
            })
            ->get();

        // Generate calendar days for the month
        $calendarDays = $this->generateCalendarDays($monthStart);
        $tasksByDay = $this->organizeTasksByDay($userTasks, $challenges, $calendarDays);

        // Return the view with the data
        return view('schedule', [
            'viewType' => 'monthly',
            'calendarDays' => $calendarDays,
            'tasksByDay' => $tasksByDay,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
            'previousMonth' => (clone $monthStart)->subMonth()->format('Y-m-d'),
            'nextMonth' => (clone $monthStart)->addMonth()->format('Y-m-d'),
        ]);
    }

    /**
     * Get the week start date from the request or use current week.
     */
    private function getWeekStartDate(Request $request): Carbon
    {
        // Configure Carbon to use Monday as the first day of the week

        if ($request->has('week')) {
            return Carbon::parse($request->week)->startOfWeek(Carbon::MONDAY);
        }

        return Carbon::now()->startOfWeek(Carbon::MONDAY);
    }

    /**
     * Get the month start date from the request or use current month.
     */
    private function getMonthStartDate(Request $request): Carbon
    {
        if ($request->has('month')) {
            return Carbon::parse($request->month)->startOfMonth();
        }

        return Carbon::now()->startOfMonth();
    }

    /**
     * Generate an array of days for the week.
     */
    private function generateWeekDays(Carbon $weekStart): array
    {
        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $day = (clone $weekStart)->addDays($i);
            $days[] = [
                'date' => $day,
                'day_name' => $day->format('l'),
                'day_number' => $day->format('d'),
                'month' => $day->format('F'),
                'year' => $day->format('Y'),
                'formatted_date' => $day->format('d F Y'),
                'is_today' => $day->isToday(),
            ];
        }

        return $days;
    }

    /**
     * Generate an array of days for the month calendar.
     */
    private function generateCalendarDays(Carbon $monthStart): array
    {
        $days = [];

        // Get the first day of the month
        $firstDay = (clone $monthStart)->startOfMonth();

        // Get the last day of the month
        $lastDay = (clone $monthStart)->endOfMonth();

        // Get the first day of the calendar (might be in the previous month)
        $calendarStart = (clone $firstDay)->startOfWeek(Carbon::MONDAY);

        // Get the last day of the calendar (might be in the next month)
        $calendarEnd = (clone $lastDay)->endOfWeek(Carbon::SUNDAY);

        // Generate all days for the calendar
        $currentDay = clone $calendarStart;
        while ($currentDay <= $calendarEnd) {
            $days[] = [
                'date' => clone $currentDay,
                'day_name' => $currentDay->format('D'),
                'day_number' => $currentDay->format('d'),
                'month' => $currentDay->format('F'),
                'year' => $currentDay->format('Y'),
                'formatted_date' => $currentDay->format('d F Y'),
                'is_today' => $currentDay->isToday(),
                'is_current_month' => $currentDay->month === $monthStart->month,
            ];

            $currentDay->addDay();
        }

        return $days;
    }

    /**
     * Organize tasks by day of the week.
     */
    private function organizeTasksByDay($userTasks, $challenges, $weekDays): array
    {
        $tasksByDay = [];

        // Initialize the array with empty arrays for each day
        foreach ($weekDays as $day) {
            $tasksByDay[$day['date']->format('Y-m-d')] = [];
        }

        // Add user tasks to the appropriate days
        foreach ($userTasks as $userTask) {
            // For tasks with completion dates, add them to that day
            if ($userTask->pivot->completed_at) {
                $completedDate = Carbon::parse($userTask->pivot->completed_at)->format('Y-m-d');

                // Only add if the completion date is within the current week
                if (isset($tasksByDay[$completedDate])) {
                    $tasksByDay[$completedDate][] = [
                        'id' => $userTask->id,
                        'name' => $userTask->name,
                        'description' => $userTask->description,
                        'type' => 'task',
                        'status' => 'completed',
                        'time' => Carbon::parse($userTask->pivot->completed_at)->format('h:i A'),
                        'color' => 'emerald', // Completed tasks are emerald
                        'challenge_name' => $userTask->challenge->name ?? null,
                    ];
                }
            }
            // For incomplete tasks, add them to today or future days based on challenge dates
            else if ($userTask->challenge && $userTask->challenge->end_date) {
                $dueDate = Carbon::parse($userTask->challenge->end_date)->format('Y-m-d');

                // Only add if the due date is within the current week
                if (isset($tasksByDay[$dueDate])) {
                    $tasksByDay[$dueDate][] = [
                        'id' => $userTask->id,
                        'name' => $userTask->name,
                        'description' => $userTask->description,
                        'type' => 'task',
                        'status' => 'pending',
                        'time' => 'Due',
                        'color' => 'amber', // Pending tasks are amber
                        'challenge_name' => $userTask->challenge->name ?? null,
                    ];
                }
            }
        }

        // Add challenges to the appropriate days
        foreach ($challenges as $challenge) {
            $startDate = Carbon::parse($challenge->start_date)->format('Y-m-d');

            // Add challenge start to the appropriate day
            if (isset($tasksByDay[$startDate])) {
                $tasksByDay[$startDate][] = [
                    'id' => $challenge->id,
                    'name' => $challenge->name,
                    'description' => $challenge->description,
                    'type' => 'challenge_start',
                    'status' => 'active',
                    'time' => Carbon::parse($challenge->start_date)->format('h:i A'),
                    'color' => 'blue', // Challenges are blue
                ];
            }

            // Add challenge end to the appropriate day
            if ($challenge->end_date) {
                $endDate = Carbon::parse($challenge->end_date)->format('Y-m-d');

                if (isset($tasksByDay[$endDate])) {
                    $tasksByDay[$endDate][] = [
                        'id' => $challenge->id,
                        'name' => $challenge->name . ' (Deadline)',
                        'description' => $challenge->description,
                        'type' => 'challenge_end',
                        'status' => 'active',
                        'time' => Carbon::parse($challenge->end_date)->format('h:i A'),
                        'color' => 'purple', // Challenge deadlines are purple
                    ];
                }
            }
        }

        return $tasksByDay;
    }
}
