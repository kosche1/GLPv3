<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentCredit;
use App\Models\StudentAchievement;
use Illuminate\Support\Facades\DB;

class StudentGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with student role
        $students = User::role('student')->get();
        
        if ($students->isEmpty()) {
            // If no students found, use all users
            $students = User::all();
        }
        
        foreach ($students as $student) {
            // Create or update student credits
            StudentCredit::updateOrCreate(
                ['user_id' => $student->id],
                [
                    'credits_completed' => rand(60, 100),
                    'credits_required' => 120,
                    'completion_percentage' => rand(50, 85),
                ]
            );
            
            // Create student achievement (used for GPA)
            StudentAchievement::updateOrCreate(
                ['user_id' => $student->id],
                [
                    'score' => rand(30, 40) / 10, // Random GPA between 3.0 and 4.0
                    'score_change' => rand(1, 20) / 100, // Random change between 0.01 and 0.20
                ]
            );
        }
    }
}
