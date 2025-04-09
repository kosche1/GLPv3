<?php

// This is a simple script to check a user's level
// Run it with: php check_level.php

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

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Current Level: " . $user->getLevel() . "\n";
echo "Current Points: " . $user->getPoints() . "\n";

// Get the levels
$levels = \LevelUp\Experience\Models\Level::orderBy('level')->get();
echo "\nLevel thresholds:\n";
foreach ($levels as $level) {
    echo "Level {$level->level}: {$level->next_level_experience} XP\n";
}

echo "\nDone!\n";
