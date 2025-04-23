<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if there are any admin users
$admins = \App\Models\Admin::all();

echo "Found " . $admins->count() . " admin users:\n";

foreach ($admins as $admin) {
    echo "- {$admin->name} ({$admin->email})\n";
}

// If no admins found, suggest creating one
if ($admins->count() === 0) {
    echo "No admin users found. You may need to run the admin seeder.\n";
}
