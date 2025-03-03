<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LevelUp\Experience\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    use HasFactory;

    /**
     * The attributes that should be appended to the model.
     *
     * @var array
     */
    protected $appends = ["points_per_action"];

    /**
     * Get the points per action.
     *
     * @return int
     */
    public function getPointsPerActionAttribute()
    {
        return $this->metadata["points_per_action"] ?? 10;
    }

    /**
     * Set the points per action.
     *
     * @param int $value
     * @return void
     */
    public function setPointsPerActionAttribute($value)
    {
        $metadata = $this->metadata ?? [];
        $metadata["points_per_action"] = $value;
        $this->metadata = $metadata;
    }
    public function updateChallengeProgress(User $user)
    {
        // Find all challenges that require this activity
        $challenges = $user
            ->challenges()
            ->wherePivotIn("status", ["enrolled", "in_progress"])
            ->whereHas("activities", function ($query) {
                $query->where("activity_id", $this->id);
            })
            ->get();

        foreach ($challenges as $challenge) {
            // Get the required count for this activity in this challenge
            $activityPivot = $challenge
                ->activities()
                ->where("activity_id", $this->id)
                ->first()->pivot;

            $requiredCount = $activityPivot->required_count ?? 1;

            // Get all challenge activities
            $totalActivities = $challenge->activities()->count();
            $completedActivities = 0;

            // Check progress on each activity
            foreach ($challenge->activities as $activity) {
                $requiredActivityCount = $activity->pivot->required_count ?? 1;
                $userActivityCount = $user
                    ->streaks()
                    ->where("activity_id", $activity->id)
                    ->sum("count");

                if ($userActivityCount >= $requiredActivityCount) {
                    $completedActivities++;
                }
            }

            // Calculate overall progress percentage
            $progressPercentage =
                $totalActivities > 0
                    ? floor(($completedActivities / $totalActivities) * 100)
                    : 0;

            // Update the user's challenge progress
            $user->updateChallengeProgress($challenge, $progressPercentage);
        }
    }
}
