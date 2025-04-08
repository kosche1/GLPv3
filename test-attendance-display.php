<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// Get a user ID
$user = User::first();

if (!$user) {
    echo "No users found in the database.\n";
    exit;
}

echo "Checking attendance records for user ID: " . $user->id . "\n";

// Get today's date
$today = now()->toDateString();
echo "Today's date: " . $today . "\n";

// Get attendance history
$attendanceHistory = StudentAttendance::getAttendanceHistory($user->id);

echo "Total attendance records: " . $attendanceHistory->count() . "\n\n";

// Check for today's record
$todayRecord = null;
foreach ($attendanceHistory as $record) {
    echo "Record date: " . $record->date->format('Y-m-d') . " (raw: " . $record->date . ")\n";
    
    if ($record->date->format('Y-m-d') === $today) {
        $todayRecord = $record;
        echo "MATCH FOUND: This is today's record!\n";
    }
}

echo "\n";

if ($todayRecord) {
    echo "Today's attendance record found:\n";
    echo "ID: " . $todayRecord->id . "\n";
    echo "Date: " . $todayRecord->date->format('Y-m-d') . "\n";
    echo "First Login Time: " . $todayRecord->first_login_time . "\n";
    echo "Last Login Time: " . $todayRecord->last_login_time . "\n";
    echo "Login Count: " . $todayRecord->login_count . "\n";
} else {
    echo "No attendance record found for today.\n";
    
    // Try direct query
    $directRecord = StudentAttendance::where('user_id', $user->id)
        ->whereDate('date', $today)
        ->first();
        
    if ($directRecord) {
        echo "\nFound record using direct query:\n";
        echo "ID: " . $directRecord->id . "\n";
        echo "Date: " . $directRecord->date->format('Y-m-d') . "\n";
        echo "First Login Time: " . $directRecord->first_login_time . "\n";
        echo "Last Login Time: " . $directRecord->last_login_time . "\n";
        echo "Login Count: " . $directRecord->login_count . "\n";
    } else {
        echo "\nNo record found using direct query either.\n";
    }
}
