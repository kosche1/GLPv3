<?php

// This is a simple script to refresh badges for a user
// Run it with: php refresh_badges.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the user ID from the command line or use a default
$userId = 30; // Change this to your user ID if needed

// Get the user
$user = \App\Models\User::find($userId);

if (!$user) {
    echo "User not found with ID: $userId\n";
    exit(1);
}

echo "Processing badges for user: {$user->name} (ID: {$user->id})\n";

// Clear the cache for this user
\Illuminate\Support\Facades\Cache::forget('user_badges_' . $user->id);
\Illuminate\Support\Facades\Cache::forget('dashboard_data_' . $user->id);

// Get the badge service
$badgeService = app(\App\Services\BadgeService::class);

// Check and award level-based badges
$awardedBadges = $badgeService->checkAndAwardLevelBadges($user);

if (count($awardedBadges) > 0) {
    echo "Awarded badges: " . implode(', ', $awardedBadges) . "\n";
} else {
    echo "No new badges awarded.\n";
}

// Get the user's current badges
$userBadges = $user->badges()->get();
echo "Current badges:\n";
foreach ($userBadges as $badge) {
    echo "- {$badge->name} (Level: {$badge->trigger_conditions['level']})\n";
}

echo "Done!\n";
