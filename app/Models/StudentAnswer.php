<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'output',
        'status',
        'is_correct',
        'score',
        'submitted_text'
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
    }
}
