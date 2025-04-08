<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, clean up any duplicate records
        $this->cleanupDuplicates();

        // Then add the unique constraint
        Schema::table('student_attendance', function (Blueprint $table) {
            $table->unique(['user_id', 'date'], 'student_attendance_user_date_unique');
        });
    }

    /**
     * Clean up duplicate attendance records before adding the unique constraint
     */
    private function cleanupDuplicates(): void
    {
        // Get all user_id and date combinations that have duplicates
        $duplicates = DB::table('student_attendance')
            ->select('user_id', 'date', DB::raw('COUNT(*) as count'))
            ->groupBy('user_id', 'date')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            // For each duplicate set, keep only the record with the lowest ID
            $records = DB::table('student_attendance')
                ->where('user_id', $duplicate->user_id)
                ->where('date', $duplicate->date)
                ->orderBy('id')
                ->get();

            // Keep the first record (lowest ID)
            $keepRecord = $records->first();

            // Delete all other records
            foreach ($records as $record) {
                if ($record->id !== $keepRecord->id) {
                    DB::table('student_attendance')
                        ->where('id', $record->id)
                        ->delete();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attendance', function (Blueprint $table) {
            $table->dropUnique('student_attendance_user_date_unique');
        });
    }
};
