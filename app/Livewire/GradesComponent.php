<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Challenge;
use App\Models\StudentCredit;
use App\Models\StudentAchievement;
use App\Models\Task;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Auth;

class GradesComponent extends Component
{
    public $currentGPA = 0;
    public $cumulativeGPA = 0;
    public $creditsCompleted = 0;
    public $creditsRequired = 120;
    public $completionPercentage = 0;
    public $targetGPA = 4.0;
    public $gpaProgressPercentage = 0;
    public $lastSemesterGPA = 0;
    public $gpaChange = 0;
    public $currentSemester = 'Spring 2025';
    public $selectedSemester = 'current';
    public $courses = [];
    public $searchQuery = '';

    public function mount()
    {
        $this->loadStudentData();
        $this->loadCourses();
    }

    public function loadStudentData()
    {
        $userId = Auth::id();

        // Get credits information
        $creditInfo = StudentCredit::getCreditsInfo($userId);
        if ($creditInfo) {
            $this->creditsCompleted = $creditInfo->credits_completed;
            $this->creditsRequired = $creditInfo->credits_required;
            $this->completionPercentage = $creditInfo->completion_percentage;
        }

        // Get GPA information (using StudentAchievement as a proxy for GPA)
        $latestScore = StudentAchievement::getLatestScore($userId);
        if ($latestScore) {
            $this->currentGPA = number_format($latestScore->score, 2);
            $this->gpaChange = number_format($latestScore->score_change, 2);

            // Calculate cumulative GPA (slightly higher for demonstration)
            $this->cumulativeGPA = number_format(min($latestScore->score + 0.07, 4.0), 2);

            // Calculate last semester GPA
            $this->lastSemesterGPA = number_format(max($this->currentGPA - $this->gpaChange, 0), 2);

            // Calculate GPA progress percentage
            $this->gpaProgressPercentage = min(round(($this->currentGPA / $this->targetGPA) * 100), 100);
        }
    }

    public function loadCourses()
    {
        $userId = Auth::id();

        // Get challenges as proxy for courses
        $challenges = Challenge::where('is_active', true)
            ->orderBy('required_level', 'asc')
            ->take(5)
            ->get();

        $courses = [];

        foreach ($challenges as $challenge) {
            // Get tasks related to this challenge
            $tasks = Task::where('challenge_id', $challenge->id)->get();

            // Calculate completion status
            $totalTasks = $tasks->count();
            $completedTasks = StudentAnswer::where('user_id', $userId)
                ->whereIn('task_id', $tasks->pluck('id'))
                ->where('is_correct', true)
                ->count();

            $status = 'Not Started';
            if ($completedTasks > 0) {
                $status = ($completedTasks >= $totalTasks) ? 'Completed' : 'In Progress';
            }

            // Calculate grade based on completed tasks
            $grade = $totalTasks > 0 ? ($completedTasks / $totalTasks) : 0;
            $letterGrade = $this->calculateLetterGrade($grade);

            // Add to courses array
            $courses[] = [
                'name' => $challenge->name,
                'code' => $this->generateCourseCode($challenge->name),
                'credits' => rand(2, 4), // Random credits for demonstration
                'grade' => $letterGrade,
                'status' => $status
            ];
        }

        $this->courses = $courses;
    }

    private function calculateLetterGrade($percentage)
    {
        // If no tasks completed (percentage is 0), return 'No Grade'
        if ($percentage <= 0) return 'No Grade';

        if ($percentage >= 0.97) return 'A+';
        if ($percentage >= 0.93) return 'A';
        if ($percentage >= 0.90) return 'A-';
        if ($percentage >= 0.87) return 'B+';
        if ($percentage >= 0.83) return 'B';
        if ($percentage >= 0.80) return 'B-';
        if ($percentage >= 0.77) return 'C+';
        if ($percentage >= 0.73) return 'C';
        if ($percentage >= 0.70) return 'C-';
        if ($percentage >= 0.67) return 'D+';
        if ($percentage >= 0.63) return 'D';
        if ($percentage >= 0.60) return 'D-';
        return 'F';
    }

    private function generateCourseCode($courseName)
    {
        // Generate a course code based on the course name
        $words = explode(' ', $courseName);
        $code = '';

        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $code .= strtoupper(substr($word, 0, 1));
            }
        }

        $code .= rand(100, 499); // Add a random number

        return $code;
    }

    public function setSemester($semester)
    {
        $this->selectedSemester = $semester;
        $this->loadCourses(); // Reload courses based on selected semester
    }

    public function render()
    {
        return view('livewire.grades-component');
    }
}
