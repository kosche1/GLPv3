<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table exists
        if (!Schema::hasTable('student_attendance')) {
            // Create the table if it doesn't exist
            Schema::create('student_attendance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->date('date');
                $table->enum('status', ['present', 'absent', 'excused'])->default('present');
                $table->text('notes')->nullable();
                $table->time('first_login_time')->nullable();
                $table->time('last_login_time')->nullable();
                $table->integer('login_count')->default(1);
                $table->timestamps();

                // Add unique constraint
                $table->unique(['user_id', 'date']);
            });

            return;
        }

        // If the table exists, check for missing columns
        if (!Schema::hasColumn('student_attendance', 'first_login_time')) {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->time('first_login_time')->nullable();
            });
        }

        if (!Schema::hasColumn('student_attendance', 'last_login_time')) {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->time('last_login_time')->nullable();
            });
        }

        if (!Schema::hasColumn('student_attendance', 'login_count')) {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->integer('login_count')->default(1);
            });
        }

        // Try to add unique constraint if it doesn't exist
        try {
            Schema::table('student_attendance', function (Blueprint $table) {
                $table->unique(['user_id', 'date'], 'student_attendance_user_id_date_unique');
            });
        } catch (\Exception $e) {
            // Constraint might already exist, that's fine
            if (!str_contains($e->getMessage(), 'already exists')) {
                throw $e;
            }
        }

        // Add test data for user ID 29 if it doesn't exist
        $exists = DB::table('student_attendance')
            ->where('user_id', 29)
            ->where('date', now()->toDateString())
            ->exists();

        if (!$exists) {
            DB::table('student_attendance')->insert([
                'user_id' => 29,
                'date' => now()->toDateString(),
                'status' => 'present',
                'notes' => 'Added by migration',
                'first_login_time' => now()->format('H:i:s'),
                'last_login_time' => now()->format('H:i:s'),
                'login_count' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse these changes
    }
};
