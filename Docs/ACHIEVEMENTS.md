# Achievement System

The achievement system rewards users for various activities in the application. Achievements are used to engage users and encourage desired behaviors.

## Types of Achievements

The system includes several types of achievements:

### Level-Based Achievements

These are awarded when users reach specific levels:

- **Getting Started**: Reach level 5 in your learning journey
- **Intermediate Learner**: Reach level 10 in your learning journey
- **Advanced Scholar**: Reach level 25 in your learning journey
- **Master of Knowledge**: Reach level 50 in your learning journey

Secret level achievements:
- **Level Milestone: 15**: Hidden achievement for reaching Level 15
- **Level Milestone: 30**: Hidden achievement for reaching Level 30

### Badge Collection Achievements

These are awarded when users collect multiple badges:

- **Badge Collector**: Collect 5 different badges
- **Badge Enthusiast**: Collect 15 different badges
- **Badge Connoisseur**: Collect 30 different badges

Secret badge achievement:
- **Badge Perfectionist**: Collect all badges in a specific category

### Login Streak Achievements

These are awarded for consistent daily logins:

- **First Week**: Log in for 7 consecutive days
- **Dedicated Learner**: Log in for 30 consecutive days
- **Consistent Scholar**: Log in for 100 consecutive days
- **Learning Lifestyle**: Log in for 365 consecutive days

Secret login achievements:
- **Weekend Warrior**: Log in on 10 consecutive weekends
- **Early Bird**: Log in before 6:00 AM 5 times
- **Night Owl**: Log in after 11:00 PM 5 times

## How Achievements are Awarded

Achievements are automatically awarded to users when they meet the criteria. The system checks for achievements in the following scenarios:

1. **User Login**: When a user logs in, the system checks for any achievements they may have earned
2. **Bulk Processing**: Administrators can run a command to check achievements for all users

## Using the Achievement System

### Checking User Achievements

To check and potentially award achievements to users, you can use the `AchievementService`:

```php
use App\Services\AchievementService;

// Create an instance of the service
$achievementService = new AchievementService();

// Check all possible achievements for a user
$achievementService->checkAllAchievements($user);

// Or check specific types of achievements
$achievementService->checkLevelAchievements($user);
$achievementService->checkBadgeCollectionAchievements($user);
$achievementService->checkLoginStreakAchievements($user);
```

### Command Line Interface

You can check and award achievements to users using the command line:

```bash
# Check achievements for all users
php artisan app:check-user-achievements

# Check achievements for a specific user
php artisan app:check-user-achievements --user=123

# Show verbose output
php artisan app:check-user-achievements --verbose
```

### Creating New Achievements

To create new achievements, you can modify the `AchievementSeeder.php` file and add new achievements:

```php
// Example of adding a new achievement
Achievement::create([
    'name' => 'New Achievement Name',
    'description' => 'Description of the achievement',
    'is_secret' => false, // Set to true for secret achievements
    'image' => 'storage/achievements/image-name.png',
]);
```

After adding new achievements to the seeder, you can run:

```bash
php artisan db:seed --class=AchievementSeeder
```

## User Experience

When a user earns an achievement, they will see a notification on their dashboard. Secret achievements are hidden until they are earned, adding an element of surprise and discovery to the system.

## Extending the Achievement System

The achievement system is designed to be extensible. To add new types of achievements:

1. Add the new achievement definitions in the `AchievementSeeder.php` file
2. Create a new method in the `AchievementService` class to check for the new achievement type
3. Update the `checkAllAchievements` method to call your new method
4. Decide when your achievement should be checked (e.g., on login, after completing a challenge, etc.) 