<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

// Get the first user
$user = User::first();

if (!$user) {
    echo "No users found\n";
    exit;
}

echo "Testing notification creation for user: " . $user->name . " (ID: " . $user->id . ")\n";

// Create a notification service
$notificationService = app(NotificationService::class);

// Create a test notification
try {
    $notification = $notificationService->createNotification(
        $user,
        "This is a test notification",
        'system',
        null,
        null
    );

    echo "Notification created successfully!\n";
    echo "ID: " . $notification->id . "\n";
    echo "Message: " . $notification->message . "\n";
    echo "Type: " . $notification->type . "\n";
    echo "Created at: " . $notification->created_at . "\n";
} catch (\Exception $e) {
    echo "Error creating notification: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Check if the notification was saved
$count = Notification::where('user_id', $user->id)->count();
echo "Total notifications for user: " . $count . "\n";

// Create a daily reward notification
try {
    $notification = $notificationService->dailyRewardNotification(
        $user,
        10,
        1,
        null
    );

    echo "Daily reward notification created successfully!\n";
    echo "ID: " . $notification->id . "\n";
    echo "Message: " . $notification->message . "\n";
    echo "Type: " . $notification->type . "\n";
    echo "Created at: " . $notification->created_at . "\n";
} catch (\Exception $e) {
    echo "Error creating daily reward notification: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Check if the notification was saved
$count = Notification::where('user_id', $user->id)->count();
echo "Total notifications for user after daily reward: " . $count . "\n";
