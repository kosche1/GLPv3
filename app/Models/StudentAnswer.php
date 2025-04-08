<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Models\User;


class StudentAnswer extends Model
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
                'user_id',
                'task_id',
                'output',
                'status',
                'is_correct',
                'score',
                'submitted_text',
                'submitted_file_path',
                'submitted_url',
                'submitted_data',
                'feedback',
                'evaluated_at',
                'evaluated_by',
            ])
            ->useLogName('Student Answer')
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

    protected $fillable = [
        'user_id',
        'task_id',
        'output',
        'status',
        'is_correct',
        'score',
        'submitted_text',
        'submitted_file_path',
        'submitted_url',
        'submitted_data',
        'feedback',
        'evaluated_at',
        'evaluated_by'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'submitted_data' => 'array',
        'evaluated_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($studentAnswer) {
            if (!isset($studentAnswer->status)) {
                $studentAnswer->status = 'submitted';
            }
            if (!isset($studentAnswer->is_correct)) {
                $studentAnswer->is_correct = null;
            }
        });

        static::updating(function ($studentAnswer) {
            // If the status is being changed to 'evaluated', set the evaluated_at timestamp
            if ($studentAnswer->isDirty('status') && $studentAnswer->status === 'evaluated' && !$studentAnswer->evaluated_at) {
                $studentAnswer->evaluated_at = now();
            }
        });
    }
}
