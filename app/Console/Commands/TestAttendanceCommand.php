<?php

namespace App\Console\Commands;

use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestAttendanceCommand extends Command
{
    protected $signature = 'test:attendance {user_id?}';
    protected $description = 'Test the attendance recording functionality';

    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if (!$userId) {
            // Get a random user
            $user = User::first();
            if (!$user) {
                $this->error('No users found in the database');
                return 1;
            }
            $userId = $user->id;
        }
        
        $this->info("Testing attendance recording for user ID: $userId");
        
        try {
            // Check if the table exists
            $tableExists = DB::getSchemaBuilder()->hasTable('student_attendance');
            
            if (!$tableExists) {
                $this->error('student_attendance table does not exist');
                return 1;
            }
            
            $this->info('student_attendance table exists');
            
            // Try to create a record directly with DB facade
            $today = now()->toDateString();
            
            $existingRecord = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
                
            if ($existingRecord) {
                $this->info('Attendance already recorded today');
                $this->table(['ID', 'User ID', 'Date', 'Status', 'Notes'], [
                    [$existingRecord->id, $existingRecord->user_id, $existingRecord->date, $existingRecord->status, $existingRecord->notes]
                ]);
            } else {
                $this->info('No existing attendance record found for today');
            }
            
            // Try with direct DB insert
            $this->info('Attempting direct DB insert...');
            
            $insertResult = DB::table('student_attendance')->insert([
                'user_id' => $userId,
                'date' => $today,
                'status' => 'present',
                'notes' => 'Test attendance record at ' . now()->format('H:i:s'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $this->info('DB insert result: ' . ($insertResult ? 'Success' : 'Failed'));
            
            // Try with the model
            $this->info('Attempting model-based insert...');
            $modelResult = StudentAttendance::recordDailyAttendance($userId);
            
            $this->info('Model result: ' . ($modelResult ? 'Success' : 'Failed'));
            
            // Check final state
            $finalRecord = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
                
            if ($finalRecord) {
                $this->info('Final attendance record:');
                $this->table(['ID', 'User ID', 'Date', 'Status', 'Notes'], [
                    [$finalRecord->id, $finalRecord->user_id, $finalRecord->date, $finalRecord->status, $finalRecord->notes]
                ]);
            } else {
                $this->error('No attendance record found after attempts');
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            Log::error('Error in test attendance command: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return 1;
        }
    }
}
