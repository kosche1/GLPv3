<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Models\User;

class Badge extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * Get the options for logging activity.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'image',
                'trigger_type',
                'trigger_conditions',
                'rarity_level',
                'is_hidden',
            ])
            ->useLogName('Badge')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // Set the log_name to the user's name if the causer is a user
        if ($activity->causer && $activity->causer instanceof User) {
            $activity->log_name = $activity->causer->name;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "description",
        "image",
        "trigger_type",
        "trigger_conditions",
        "rarity_level",
        "is_hidden",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "trigger_conditions" => "array",
        "is_hidden" => "boolean",
    ];

    /**
     * Get the users who have earned this badge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_badges")
            ->withPivot("earned_at", "is_pinned", "is_showcased")
            ->withTimestamps();
    }
}
