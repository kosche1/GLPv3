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

echo "Testing attendance recording for user ID: " . $user->id . "\n";

try {
    // Record attendance
    $result = StudentAttendance::recordDailyAttendance($user->id);
    
    if ($result) {
        echo "Attendance recorded successfully!\n";
        echo "Record ID: " . $result->id . "\n";
        echo "User ID: " . $result->user_id . "\n";
        echo "Date: " . $result->date . "\n";
        echo "Status: " . $result->status . "\n";
        echo "First Login Time: " . $result->first_login_time . "\n";
        echo "Last Login Time: " . $result->last_login_time . "\n";
        echo "Login Count: " . $result->login_count . "\n";
        echo "Notes: " . $result->notes . "\n";
    } else {
        echo "Failed to record attendance.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

// Check if the record exists in the database
$records = StudentAttendance::where('user_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

echo "\nRecent attendance records for user ID " . $user->id . ":\n";

if ($records->isEmpty()) {
    echo "No records found.\n";
} else {
    foreach ($records as $record) {
        echo "ID: " . $record->id . "\n";
        echo "Date: " . $record->date . "\n";
        echo "Status: " . $record->status . "\n";
        echo "First Login Time: " . $record->first_login_time . "\n";
        echo "Last Login Time: " . $record->last_login_time . "\n";
        echo "Login Count: " . $record->login_count . "\n";
        echo "Notes: " . $record->notes . "\n";
        echo "Created At: " . $record->created_at . "\n";
        echo "Updated At: " . $record->updated_at . "\n";
        echo "-------------------\n";
    }
}
