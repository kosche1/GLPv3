<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private user channel for personal notifications
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Public leaderboard channel
Broadcast::channel('leaderboard', function ($user) {
    return $user !== null; // Any authenticated user can listen
});

// Public activity feed channel
Broadcast::channel('activity-feed', function ($user) {
    return $user !== null; // Any authenticated user can listen
});

// Challenge-specific channels
Broadcast::channel('challenge.{challengeId}', function ($user, $challengeId) {
    // Check if user is enrolled in this challenge
    return $user->challenges()->where('challenge_id', $challengeId)->exists();
});

// Admin channels for real-time monitoring
Broadcast::channel('admin.dashboard', function ($user) {
    return $user->hasRole('admin') || $user->hasRole('faculty');
});
