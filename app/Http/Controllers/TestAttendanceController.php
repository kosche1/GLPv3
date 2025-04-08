<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestAttendanceController extends Controller
{
    public function index()
    {
        return view('test-attendance');
    }

    public function testAttendance()
    {
        try {
            $userId = Auth::check() ? Auth::id() : null;

            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Log the attempt
            Log::info('Attempting to record attendance for user: ' . $userId);

            // Check if the table exists
            $tableExists = DB::getSchemaBuilder()->hasTable('student_attendance');

            if (!$tableExists) {
                return response()->json(['error' => 'student_attendance table does not exist'], 500);
            }

            // Try to create a record directly with DB facade
            $today = now()->toDateString();

            $existingRecord = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'message' => 'Attendance already recorded today',
                    'record' => $existingRecord
                ]);
            }

            $insertResult = DB::table('student_attendance')->insert([
                'user_id' => $userId,
                'date' => $today,
                'status' => 'present',
                'notes' => 'Test attendance record at ' . now()->format('H:i:s'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Also try with the model
            $modelResult = StudentAttendance::recordDailyAttendance($userId);

            // Check if the record was created
            $checkRecord = DB::table('student_attendance')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();

            return response()->json([
                'message' => 'Test completed',
                'db_insert_result' => $insertResult,
                'model_result' => $modelResult,
                'user_id' => $userId,
                'date' => $today,
                'record' => $checkRecord
            ]);
        } catch (\Exception $e) {
            Log::error('Error in test attendance: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
