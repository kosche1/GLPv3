<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ForumTopic;
use App\Models\ForumComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();

        // Get real user level and experience points from the experiences table
        $userExperience = DB::table('experiences')
            ->where('user_id', $user->id)
            ->first();

        // Default values if no experience record exists
        $currentLevel = 1;
        $currentPoints = 0;

        if ($userExperience) {
            $currentLevel = $userExperience->level_id;
            $currentPoints = $userExperience->experience_points;
        }

        // Get next level experience points
        $nextLevelExp = DB::table('levels')
            ->where('level', $currentLevel + 1)
            ->value('next_level_experience');

        // Calculate progress percentage to next level
        $currentLevelExp = DB::table('levels')
            ->where('level', $currentLevel)
            ->value('next_level_experience') ?? 0;

        $progressPercentage = 0;
        if ($nextLevelExp && $nextLevelExp > $currentLevelExp) {
            $levelDiff = $nextLevelExp - $currentLevelExp;
            $userProgress = $currentPoints - $currentLevelExp;
            $progressPercentage = min(100, max(0, round(($userProgress / $levelDiff) * 100)));
        } elseif (!$nextLevelExp) {
            // User is at max level
            $progressPercentage = 100;
        }

        // Get all challenges
        $challenges = DB::table('challenges')
            ->where('is_active', true)
            ->get();

        // Get total number of challenges
        $totalChallenges = $challenges->count();

        // Get all tasks
        $tasks = DB::table('tasks')
            ->whereIn('challenge_id', $challenges->pluck('id'))
            ->get();

        // Get completed tasks for the user
        $completedTaskIds = DB::table('student_answers')
            ->where('user_id', $user->id)
            ->whereIn('task_id', $tasks->pluck('id'))
            ->pluck('task_id')
            ->toArray();

        // Get user challenges with completion data - both from user_challenges table and from completed tasks
        $userChallenges = DB::table('user_challenges')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->get();

        // Also check for challenges that are completed based on student_answers
        $completedTasksByChallenge = DB::table('student_answers')
            ->join('tasks', 'student_answers.task_id', '=', 'tasks.id')
            ->where('student_answers.user_id', $user->id)
            ->where('student_answers.is_correct', true)
            ->select('tasks.challenge_id', DB::raw('count(*) as completed_count'))
            ->groupBy('tasks.challenge_id')
            ->get();

        // Create a map of challenge IDs to completion dates
        $challengeCompletionDates = [];
        foreach ($userChallenges as $userChallenge) {
            $challengeCompletionDates[$userChallenge->challenge_id] = $userChallenge->completed_at;
        }

        // Determine completed challenges
        $completedChallengeIds = [];
        $recentActivities = collect();

        // First, add challenges that are marked as completed in user_challenges table
        foreach ($userChallenges as $userChallenge) {
            if (!in_array($userChallenge->challenge_id, $completedChallengeIds)) {
                $completedChallengeIds[] = $userChallenge->challenge_id;
            }
        }

        // Then check for challenges where all tasks are completed
        foreach ($challenges as $challenge) {
            // Skip if already marked as completed
            if (in_array($challenge->id, $completedChallengeIds)) {
                continue;
            }

            // Get tasks for this challenge
            $challengeTasks = $tasks->where('challenge_id', $challenge->id);
            $totalChallengeTasks = $challengeTasks->count();

            if ($totalChallengeTasks > 0) {
                // Check if we have a record in completedTasksByChallenge
                $completedTasksRecord = $completedTasksByChallenge->firstWhere('challenge_id', $challenge->id);

                // If we have a record and all tasks are completed, mark the challenge as completed
                if ($completedTasksRecord && $completedTasksRecord->completed_count >= $totalChallengeTasks) {
                    $completedChallengeIds[] = $challenge->id;
                } else {
                    // Count completed tasks for this challenge manually
                    $completedChallengeTasks = 0;

                    foreach ($challengeTasks as $task) {
                        if (in_array($task->id, $completedTaskIds)) {
                            $completedChallengeTasks++;
                        }
                    }

                    // If all tasks in the challenge are completed, mark the challenge as completed
                    if ($completedChallengeTasks >= $totalChallengeTasks) {
                        $completedChallengeIds[] = $challenge->id;
                    }
                }
            }
        }

        // Now build the recentActivities collection from completed challenges
        foreach ($challenges as $challenge) {
            if (in_array($challenge->id, $completedChallengeIds)) {
                // Get the actual completion date from user_challenges if available
                $completedAt = isset($challengeCompletionDates[$challenge->id])
                    ? $challengeCompletionDates[$challenge->id]
                    : now(); // Fallback to current time if no record exists

                // Add to recent activities
                $recentActivities->push((object)[
                    'id' => $challenge->id,
                    'name' => $challenge->name,
                    'description' => $challenge->description,
                    'points_changed' => $challenge->points_reward ?? 100,
                    'created_at' => $completedAt,
                    'programming_language' => $challenge->programming_language
                ]);
            }
        }

        // Sort by most recent - no limit since we have a scrollable container
        $recentActivities = $recentActivities->sortByDesc('created_at');

        // For statistics, we need the count of completed challenges
        $completedChallenges = count($completedChallengeIds);

        // Get user achievements from the database
        $achievements = DB::table('achievement_user')
            ->join('achievements', 'achievement_user.achievement_id', '=', 'achievements.id')
            ->where('achievement_user.user_id', $user->id)
            ->select('achievements.*', 'achievement_user.unlocked_at as earned_at')
            ->get();

        // Get user badges from the database
        $badges = DB::table('user_badges')
            ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
            ->where('user_badges.user_id', $user->id)
            ->select('badges.*', 'user_badges.earned_at')
            ->get();

        // Get real statistics
        $forumPostsCount = ForumTopic::where('user_id', $user->id)->count() +
                          ForumComment::where('user_id', $user->id)->count();

        // Get completed tasks count from user_tasks table
        $completedTasks = DB::table('user_tasks')
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        // If no completed tasks found in user_tasks, try counting from student_answers as fallback
        if ($completedTasks == 0) {
            $completedTasks = DB::table('student_answers')
                ->where('user_id', $user->id)
                ->where('is_correct', true)
                ->distinct('task_id')
                ->count('task_id');
        }

        // Get learning progress - challenges with progress
        $learningProgress = collect();
        $userChallenges = DB::table('user_challenges')
            ->join('challenges', 'user_challenges.challenge_id', '=', 'challenges.id')
            ->where('user_challenges.user_id', $user->id)
            ->select('challenges.id', 'challenges.name')
            ->get();

        foreach ($userChallenges as $challenge) {
            // Get total tasks for this challenge
            $totalTasks = DB::table('tasks')
                ->where('challenge_id', $challenge->id)
                ->count();

            if ($totalTasks > 0) {
                // Get completed tasks for this challenge
                $completedTasksCount = DB::table('user_tasks')
                    ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
                    ->where('user_tasks.user_id', $user->id)
                    ->where('tasks.challenge_id', $challenge->id)
                    ->where('user_tasks.completed', true)
                    ->count();

                $progress = round(($completedTasksCount / $totalTasks) * 100);

                $learningProgress->push([
                    'name' => $challenge->name,
                    'progress' => $progress,
                ]);
            }
        }

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($user);

        return view('profile', compact(
            'user',
            'currentLevel',
            'currentPoints',
            'progressPercentage',
            'recentActivities',
            'achievements',
            'badges',
            'forumPostsCount',
            'completedChallenges',
            'completedTasks',
            'learningProgress',
            'profileCompletion',
            'totalChallenges'
        ));
    }

    /**
     * Calculate the user's profile completion percentage.
     */
    private function calculateProfileCompletion(User $user)
    {
        // Real profile completion calculation based on actual user data
        $completionItems = [
            'profile_picture' => !empty($user->avatar),
            'about_me' => !empty($user->bio),
            'skills' => !empty($user->skills),
        ];

        $completedItems = count(array_filter($completionItems));
        $totalItems = count($completionItems);

        $percentage = ($totalItems > 0) ? round(($completedItems / $totalItems) * 100) : 0;

        return [
            'percentage' => $percentage,
            'items' => $completionItems,
        ];
    }
}
