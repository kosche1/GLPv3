<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'student_answer',
        'is_correct'
    ];

    protected $casts = [
        'student_answer' => 'array',
        'is_correct' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($studentAnswer) {
            // Automatically check if the answer is correct when saving
            $studentAnswer->is_correct = $studentAnswer->task->checkAnswer($studentAnswer->student_answer);
        });
    }
}