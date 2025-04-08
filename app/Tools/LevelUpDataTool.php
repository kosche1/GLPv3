<?php

declare(strict_types=1);

namespace App\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LevelUp\Experience\Facades\Leaderboard;
use LevelUp\Experience\Models\Activity;
use Prism\Prism\Facades\Tool;
use Prism\Prism\Schema\EnumSchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Tool as BaseTool;

class LevelUpDataTool extends BaseTool
{
    public function __construct()
    {
        Log::info('LevelUpDataTool constructor called.');
        // Register the tool with Prism
        // Tool::register($this); // Re-commented this line

        $this->as('level_up_data')
            ->for(
                "Retrieves user-specific gamification data including level, experience points, achievements, streaks, and leaderboard information. " .
                "Use this tool to answer questions about the user's current level, experience, achievements, streaks, and leaderboard rankings."
            )
            ->withParameter(
                new EnumSchema(
                    name: 'query_type',
                    description: 'The type of query to perform: get level, get experience, get achievements, get streaks, or get leaderboard.',
                    options: [
                        'get_user_level',
                        'get_user_experience',
                        'get_user_achievements',
                        'get_user_streaks',
                        'get_leaderboard'
                    ]
                )
            )
            ->withParameter(
                new NumberSchema(
                    name: 'limit',
                    description: 'The maximum number of leaderboard entries to return (default: 10). Only used with query_type get_leaderboard.'
                )
            )
            ->using($this);
    }

    public function __invoke(string $query_type, ?int $limit = null): string
    {
        $user = Auth::user();

        if (!$user) {
            return $this->encodeError('User not authenticated. Please log in to view your level and experience data.');
        }

        Log::info('LevelUpDataTool invoked', [
            'user_id' => $user->id,
            'query_type' => $query_type,
            'limit' => $limit
        ]);

        try {
            $result = match ($query_type) {
                'get_user_level' => $this->getUserLevel($user),
                'get_user_experience' => $this->getUserExperience($user),
                'get_user_achievements' => $this->getUserAchievements($user),
                'get_user_streaks' => $this->getUserStreaks($user),
                'get_leaderboard' => $this->getLeaderboard($limit ?? 10),
                default => ['error' => 'Invalid query_type for LevelUpDataTool: ' . $query_type],
            };
        } catch (\Exception $e) {
            Log::error('LevelUpDataTool Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $result = ['error' => 'An internal error occurred: ' . $e->getMessage()];
        }

        return $this->limitJsonString(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Get the user's current level information
     *
     * @param \App\Models\User $user The user
     * @return array Level information
     */
    private function getUserLevel($user): array
    {
        // Check if the user has the GiveExperience trait
        if (!method_exists($user, 'getLevel')) {
            return ['error' => 'The user model does not have level functionality. Make sure the GiveExperience trait is added to your User model.'];
        }

        // Get the user's level data
        $level = $user->getLevel();
        $nextLevelAt = $user->nextLevelAt();
        $points = $user->getPoints();
        $pointsNeeded = $nextLevelAt ? ($nextLevelAt - $points) : null;
        $maxLevelReached = $nextLevelAt === null;

        return [
            'user_level' => [
                'user' => $user->name,
                'current_level' => $level,
                'current_xp' => $points,
                'next_level_at' => $nextLevelAt,
                'points_needed_for_next_level' => $pointsNeeded,
                'max_level_reached' => $maxLevelReached,
            ]
        ];
    }

    /**
     * Get the user's experience details
     *
     * @param \App\Models\User $user The user
     * @return array Experience information
     */
    private function getUserExperience($user): array
    {
        // Check if the user has the GiveExperience trait
        if (!method_exists($user, 'getPoints')) {
            return ['error' => 'The user model does not have experience functionality. Make sure the GiveExperience trait is added to your User model.'];
        }

        // Get the user's experience data
        $points = $user->getPoints();
        $level = $user->getLevel();

        $result = [
            'user_experience' => [
                'user' => $user->name,
                'total_xp' => $points,
                'current_level' => $level,
            ]
        ];

        // Add experience history if auditing is enabled
        if (method_exists($user, 'experienceHistory')) {
            $history = $user->experienceHistory()->latest()->take(5)->get();

            if ($history->count() > 0) {
                $result['recent_history'] = $history->map(function ($entry) {
                    return [
                        'date' => $entry->created_at->format('Y-m-d H:i'),
                        'points' => $entry->points,
                        'type' => $entry->type,
                        'reason' => $entry->reason,
                    ];
                })->toArray();
            } else {
                $result['recent_history'] = [];
            }
        }

        return $result;
    }

    /**
     * Get the user's achievements
     *
     * @param \App\Models\User $user The user
     * @return array Achievement information
     */
    private function getUserAchievements($user): array
    {
        if (!method_exists($user, 'achievements')) {
            return ['error' => 'The user model does not have achievement functionality. Make sure the HasAchievements trait is added to your User model.'];
        }

        try {
            // Get achievements including progress
            $achievements = $user->achievements()->withPivot('progress', 'unlocked_at')->get();
            $allAchievements = \LevelUp\Experience\Models\Achievement::all(); // Get all possible achievements for context

            if ($achievements->isEmpty()) {
                return [
                    'user_achievements' => [
                        'user' => $user->name,
                        'message' => 'No achievements unlocked yet.',
                        'total_possible_achievements' => $allAchievements->count(),
                    ]
                ];
            }

            $achievementsData = $achievements->map(function ($achievement) {
                return [
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'is_secret' => $achievement->is_secret,
                    'unlocked_at' => $achievement->pivot->unlocked_at ? $achievement->pivot->unlocked_at->format('Y-m-d H:i') : null,
                    'progress' => $achievement->pivot->progress,
                ];
            })->toArray();

            return [
                'user_achievements' => [
                    'user' => $user->name,
                    'unlocked_count' => $achievements->where('pivot.progress', 100)->count(),
                    'in_progress_count' => $achievements->where('pivot.progress', '<', 100)->count(),
                    'total_possible_achievements' => $allAchievements->count(),
                    'achievements' => $achievementsData,
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching achievements', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return ['error' => 'Could not retrieve achievement data. ' . $e->getMessage()];
        }
    }

    /**
     * Get the user's current streaks
     *
     * @param \App\Models\User $user The user
     * @return array Streak information
     */
    private function getUserStreaks($user): array
    {
        if (!method_exists($user, 'streaks')) {
            return ['error' => 'The user model does not have streak functionality. Make sure the HasStreaks trait is added to your User model.'];
        }
        if (!class_exists(Activity::class)) {
            return ['error' => 'Activity model not found for streaks.'];
        }

        try {
            $activities = Activity::all();
            if ($activities->isEmpty()) {
                return ['message' => 'No activities configured for tracking streaks.'];
            }

            $streaksData = [];
            $userStreaks = $user->streaks()->with('activity')->get()->keyBy('activity_id');

            foreach ($activities as $activity) {
                $streak = $userStreaks->get($activity->id);
                $currentCount = $streak->count ?? 0;
                $lastActivityDate = $streak->streaked_at ?? null;
                $isFrozen = $streak && $streak->frozen_until && $streak->frozen_until->isFuture();
                $frozenUntil = $isFrozen ? $streak->frozen_until->format('Y-m-d H:i') : null;

                $hasStreakToday = false;
                if ($lastActivityDate) {
                    $lastDate = \Carbon\Carbon::parse($lastActivityDate);
                    $now = now();
                    if ($isFrozen && $now->lessThanOrEqualTo($streak->frozen_until)) {
                        $hasStreakToday = true;
                    } elseif ($lastDate->isToday()) {
                        $hasStreakToday = true;
                    } elseif ($lastDate->isYesterday()) {
                        // Streak might continue today, but we only know the last date
                        // Let's report false unless explicitly asked "Did I do X today?"
                        // $hasStreakToday = false;
                    }
                }

                $streaksData[] = [
                    'activity_name' => $activity->name,
                    'current_streak' => $currentCount,
                    'last_active_date' => $lastActivityDate ? \Carbon\Carbon::parse($lastActivityDate)->format('Y-m-d H:i') : 'Never',
                    'is_frozen' => $isFrozen,
                    'frozen_until' => $frozenUntil,
                    'active_today' => $hasStreakToday,
                ];
            }

            return [
                'user_streaks' => [
                    'user' => $user->name,
                    'streaks' => $streaksData,
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching streaks', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return ['error' => 'Could not retrieve streak data. ' . $e->getMessage()];
        }
    }

    /**
     * Get the leaderboard
     *
     * @param int $limit The number of users to include
     * @return array Leaderboard information
     */
    private function getLeaderboard(int $limit = 10): array
    {
        // Generate the leaderboard
        $leaderboard = Leaderboard::generate()->take($limit);

        if ($leaderboard->isEmpty()) {
            return ['error' => 'No leaderboard data available.'];
        }

        $leaderboardData = [];
        $rank = 1;

        foreach ($leaderboard as $entry) {
            $leaderboardData[] = [
                'rank' => $rank,
                'user' => $entry->name ?? 'Unknown',
                'level' => $entry->level->level ?? 'N/A',
                'xp' => $entry->experience->points ?? 0,
            ];
            $rank++;
        }

        $result = [
            'leaderboard' => $leaderboardData
        ];

        // Add current user's rank if authenticated
        if (Auth::check()) {
            $currentUser = Auth::user();
            $allUsers = Leaderboard::generate();

            $userRank = 0;
            foreach ($allUsers as $index => $entry) {
                if ($entry->id === $currentUser->id) {
                    $userRank = $index + 1;
                    break;
                }
            }

            if ($userRank > 0) {
                $result['current_user_rank'] = $userRank;
            }
        }

        return $result;
    }

    /**
     * Encode an error message as JSON
     *
     * @param string $message The error message
     * @return string JSON-encoded error
     */
    private function encodeError(string $message): string
    {
        return json_encode(['error' => $message]);
    }

    /**
     * Limit the length of a JSON string
     *
     * @param string $jsonString The JSON string to limit
     * @param int $maxLength Maximum length
     * @return string Truncated JSON string
     */
    private function limitJsonString(string $jsonString, int $maxLength = 8000): string
    {
        if (mb_strlen($jsonString) <= $maxLength) {
            return $jsonString;
        }

        // Attempt to truncate intelligently (simple version)
        try {
            $data = json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
            $truncated = false;

            $walkAndTruncate = function (&$item) use (&$walkAndTruncate, &$truncated) {
                if (is_array($item)) {
                    if (array_keys($item) === range(0, count($item) - 1) && count($item) > 5) {
                        $item = array_slice($item, 0, 5);
                        $item[] = '... (truncated)';
                        $truncated = true;
                    } else {
                        foreach ($item as &$value) $walkAndTruncate($value); unset($value);
                    }
                }
            };
            $walkAndTruncate($data);

            if ($truncated) {
                $truncatedJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                if (mb_strlen($truncatedJson) <= $maxLength) return $truncatedJson;
            }
        } catch (\JsonException $e) {
            Log::warning('JSON decoding failed during truncation in LevelUpDataTool', ['error' => $e->getMessage()]);
        }

        // Fallback: Hard truncate
        $cutPosition = max(
            strrpos(substr($jsonString, 0, $maxLength - 50), ','),
            strrpos(substr($jsonString, 0, $maxLength - 50), '}'),
            strrpos(substr($jsonString, 0, $maxLength - 50), ']')
        );

        if ($cutPosition > $maxLength / 2) {
            return substr($jsonString, 0, $cutPosition) . "\n... // TRUNCATED DUE TO LENGTH\n}";
        } else {
            return mb_substr($jsonString, 0, $maxLength - 20) . '... [TRUNCATED]';
        }
    }
}
