<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a new notification for a user.
     *
     * @param User $user
     * @param string $message
     * @param string $type
     * @param string|null $link
     * @param array|null $data
     * @return Notification
     */
    public function createNotification(User $user, string $message, string $type = 'system', ?string $link = null, ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'message' => $message,
            'type' => $type,
            'read' => false,
            'link' => $link,
            'data' => $data,
        ]);
    }

    /**
     * Create an achievement notification.
     *
     * @param User $user
     * @param string $achievementName
     * @param string|null $link
     * @return Notification
     */
    public function achievementNotification(User $user, string $achievementName, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "You've earned the achievement: {$achievementName}!",
            'achievement',
            $link
        );
    }

    /**
     * Create a badge notification.
     *
     * @param User $user
     * @param string $badgeName
     * @param string|null $link
     * @return Notification
     */
    public function badgeNotification(User $user, string $badgeName, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "You've earned a new badge: {$badgeName}!",
            'achievement',
            $link
        );
    }

    /**
     * Create a level up notification.
     *
     * @param User $user
     * @param int $level
     * @param string|null $link
     * @return Notification
     */
    public function levelUpNotification(User $user, int $level, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "Congratulations! You've reached level {$level}!",
            'achievement',
            $link
        );
    }

    /**
     * Create a new challenge notification.
     *
     * @param User $user
     * @param string $challengeName
     * @param string|null $link
     * @return Notification
     */
    public function newChallengeNotification(User $user, string $challengeName, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "New challenge available: {$challengeName}",
            'challenge',
            $link
        );
    }

    /**
     * Create a grade notification.
     *
     * @param User $user
     * @param string $taskName
     * @param string $grade
     * @param string|null $link
     * @return Notification
     */
    public function gradeNotification(User $user, string $taskName, string $grade, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "Your submission for '{$taskName}' has been graded: {$grade}",
            'grade',
            $link
        );
    }

    /**
     * Create a feedback notification.
     *
     * @param User $user
     * @param string $taskName
     * @param string|null $link
     * @return Notification
     */
    public function feedbackNotification(User $user, string $taskName, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "You've received feedback on your submission for '{$taskName}'",
            'grade',
            $link
        );
    }

    /**
     * Create a system notification.
     *
     * @param User $user
     * @param string $message
     * @param string|null $link
     * @return Notification
     */
    public function systemNotification(User $user, string $message, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            $message,
            'system',
            $link
        );
    }

    /**
     * Create a daily reward notification.
     *
     * @param User $user
     * @param int $points
     * @param int $streak
     * @param string|null $link
     * @return Notification
     */
    public function dailyRewardNotification(User $user, int $points, int $streak, ?string $link = null): Notification
    {
        return $this->createNotification(
            $user,
            "You received {$points} points for your Day {$streak} login streak!",
            'reward',
            $link
        );
    }
}
