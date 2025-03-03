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
}
