<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DatabaseFixController extends Controller
{
    public function fixStudentAnswersTable()
    {
        $results = [
            'status' => 'unknown',
            'message' => '',
            'actions' => []
        ];

        try {
            // Check if the table exists
            if (!Schema::hasTable('student_answers')) {
                $results['actions'][] = 'Table does not exist, attempting to create it';
                
                // Create the table
                Schema::create('student_answers', function ($table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                    $table->foreignId('task_id')->constrained()->onDelete('cascade');
                    $table->longText('submitted_text')->nullable();
                    $table->string('submitted_file_path')->nullable();
                    $table->string('submitted_url')->nullable();
                    $table->json('submitted_data')->nullable();
                    $table->boolean('is_correct')->nullable();
                    $table->decimal('score', 8, 2)->nullable();
                    $table->text('feedback')->nullable();
                    $table->string('status')->default('submitted');
                    $table->timestamp('evaluated_at')->nullable();
                    $table->foreignId('evaluated_by')->nullable();
                    $table->timestamps();
                });
                
                $results['actions'][] = 'Table created successfully';
            } else {
                $results['actions'][] = 'Table already exists';
                
                // Check if the table has the required columns
                $columns = Schema::getColumnListing('student_answers');
                $requiredColumns = [
                    'id', 'user_id', 'task_id', 'submitted_text', 'is_correct', 
                    'status', 'created_at', 'updated_at'
                ];
                
                $missingColumns = array_diff($requiredColumns, $columns);
                
                if (!empty($missingColumns)) {
                    $results['actions'][] = 'Missing columns: ' . implode(', ', $missingColumns);
                    
                    // Add missing columns
                    Schema::table('student_answers', function ($table) use ($missingColumns) {
                        if (in_array('submitted_text', $missingColumns)) {
                            $table->longText('submitted_text')->nullable();
                        }
                        if (in_array('is_correct', $missingColumns)) {
                            $table->boolean('is_correct')->nullable();
                        }
                        if (in_array('status', $missingColumns)) {
                            $table->string('status')->default('submitted');
                        }
                    });
                    
                    $results['actions'][] = 'Added missing columns';
                } else {
                    $results['actions'][] = 'All required columns exist';
                }
            }
            
            // Test inserting a record
            $testRecord = DB::table('student_answers')->insert([
                'user_id' => 1, // Assuming user ID 1 exists
                'task_id' => 1, // Assuming task ID 1 exists
                'submitted_text' => 'Test submission from database fix controller',
                'is_correct' => false,
                'status' => 'submitted',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            if ($testRecord) {
                $results['actions'][] = 'Successfully inserted a test record';
            } else {
                $results['actions'][] = 'Failed to insert a test record';
            }
            
            $results['status'] = 'success';
            $results['message'] = 'Database fix completed successfully';
            
        } catch (\Exception $e) {
            $results['status'] = 'error';
            $results['message'] = 'Error: ' . $e->getMessage();
            $results['actions'][] = 'Exception occurred: ' . $e->getMessage();
            
            Log::error('Database fix error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return response()->json($results);
    }
}
