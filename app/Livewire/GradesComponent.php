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
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function mount()
    {
        $this->loadCourses();
        $this->loadStudentData();
    }

    public function loadStudentData()
    {
        $userId = Auth::id();

        // Calculate GPA and credits from current courses
        $totalPoints = 0;
        $totalCredits = 0;
        $completedCredits = 0;

        foreach ($this->courses as $course) {
            $credits = $course['credits'];

            // Only include courses with actual grades (not "No Grade")
            if ($course['grade'] !== 'No Grade') {
                $gradePoints = $this->getGradePoints($course['grade']);
                $totalPoints += ($gradePoints * $credits);
                $totalCredits += $credits;

                // Count completed credits
                if ($course['status'] === 'Completed') {
                    $completedCredits += $credits;
                }
            }
        }

        // Calculate current GPA
        $this->currentGPA = $totalCredits > 0 ?
            number_format($totalPoints / $totalCredits, 2) :
            0.00;

        // Get previous GPA for comparison
        $previousGPA = StudentAchievement::getLatestScore($userId);
        $this->gpaChange = $previousGPA ?
            number_format($this->currentGPA - $previousGPA->score, 2) :
            0.00;

        // Calculate cumulative GPA (weighted average of current and previous)
        $previousCredits = StudentCredit::where('user_id', $userId)->value('credits_completed') ?? 0;
        $previousPoints = $previousGPA ? ($previousGPA->score * $previousCredits) : 0;

        $totalCumulativeCredits = $previousCredits + $totalCredits;
        $this->cumulativeGPA = $totalCumulativeCredits > 0 ?
            number_format(($previousPoints + $totalPoints) / $totalCumulativeCredits, 2) :
            0.00;

        // Update credits information
        $this->creditsCompleted = $completedCredits;
        $this->creditsRequired = 120; // Your standard requirement
        $this->completionPercentage = round(($completedCredits / $this->creditsRequired) * 100, 2);

        // Calculate GPA progress percentage
        $this->gpaProgressPercentage = min(round(($this->currentGPA / $this->targetGPA) * 100), 100);
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
                'credits' => $this->getCreditsForChallenge($challenge), // Use deterministic credits
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $filteredCourses = collect($this->courses);

        // Apply search filter
        if (!empty($this->searchQuery)) {
            $filteredCourses = $filteredCourses->filter(function ($course) {
                return stripos($course['name'], $this->searchQuery) !== false ||
                       stripos($course['code'], $this->searchQuery) !== false ||
                       stripos($course['grade'], $this->searchQuery) !== false ||
                       stripos($course['status'], $this->searchQuery) !== false;
            });
        }

        // Apply sorting
        $filteredCourses = $filteredCourses->sortBy(function ($course) {
            switch ($this->sortField) {
                case 'name':
                    return $course['name'];
                case 'code':
                    return $course['code'];
                case 'credits':
                    return $course['credits'];
                case 'grade':
                    // Sort grades by their point value for better ordering
                    return $this->getGradePoints($course['grade']);
                case 'status':
                    return $course['status'];
                default:
                    return $course['name'];
            }
        }, SORT_REGULAR, $this->sortDirection === 'desc');

        return view('livewire.grades-component', [
            'courses' => $filteredCourses->values()->all()
        ]);
    }

    private function getGradePoints($grade)
    {
        return match($grade) {
            'A+' => 4.0,
            'A'  => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B'  => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C'  => 2.0,
            'C-' => 1.7,
            'D+' => 1.3,
            'D'  => 1.0,
            'D-' => 0.7,
            'F'  => 0.0,
            default => 0.0,
        };
    }

    /**
     * Get a deterministic credit value for a challenge
     * This ensures the same challenge always gets the same credit value
     */
    private function getCreditsForChallenge($challenge)
    {
        // Use the challenge ID to determine credits (between 2-4)
        // This ensures the same challenge always gets the same credit value
        if ($challenge->id % 3 === 0) {
            return 4; // Advanced courses (divisible by 3)
        } elseif ($challenge->id % 2 === 0) {
            return 3; // Intermediate courses (divisible by 2 but not 3)
        } else {
            return 2; // Basic courses (not divisible by 2 or 3)
        }
    }
}


