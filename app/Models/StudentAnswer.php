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
        'student_answer',
        'solution',
        'output',
        'status',
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

        static::creating(function ($studentAnswer) {
            // Set default values if not provided
            if (Schema::hasColumn('student_answers', 'is_correct') && !isset($studentAnswer->is_correct)) {
                $studentAnswer->is_correct = false;
            }
            
            if (!isset($studentAnswer->status)) {
                $studentAnswer->status = 'pending';
            }
        });

        static::saving(function ($studentAnswer) {
            // Only proceed if the is_correct column exists
            if (!Schema::hasColumn('student_answers', 'is_correct')) {
                return;
            }
            
            try {
                // Only check answer if task exists and we haven't already set is_correct
                if ($studentAnswer->task && !$studentAnswer->isDirty('is_correct')) {
                    Log::info('Checking answer in StudentAnswer model', [
                        'student_answer_id' => $studentAnswer->id,
                        'task_id' => $studentAnswer->task_id
                    ]);
                    
                    // Check if student_answer column exists
                    $hasStudentAnswerColumn = Schema::hasColumn('student_answers', 'student_answer');
                    
                    if ($hasStudentAnswerColumn && isset($studentAnswer->student_answer)) {
                        $studentAnswer->is_correct = $studentAnswer->task->checkAnswer($studentAnswer->student_answer);
                    } else {
                        // Create a temporary student_answer array from solution and output
                        $tempStudentAnswer = [
                            'code' => $studentAnswer->solution ?? '',
                            'output' => $studentAnswer->output ?? '',
                            'language' => 'python' // Default language
                        ];
                        $studentAnswer->is_correct = $studentAnswer->task->checkAnswer($tempStudentAnswer);
                    }
                    
                    Log::info('Answer checked', [
                        'is_correct' => $studentAnswer->is_correct
                    ]);
                }
            } catch (\Exception $e) {
                // Log the error but don't prevent saving
                Log::error('Error checking answer in StudentAnswer model:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'student_answer_id' => $studentAnswer->id ?? 'new',
                    'task_id' => $studentAnswer->task_id ?? null
                ]);
                
                // Set is_correct to false on error
                $studentAnswer->is_correct = false;
            }
        });
    }
}