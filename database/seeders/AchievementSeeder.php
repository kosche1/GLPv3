<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LevelUp\Experience\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level-based achievements
        $this->createLevelAchievements();
        
        // Badge collection achievements
        $this->createBadgeCollectionAchievements();
        
        // Login streak achievements
        $this->createLoginStreakAchievements();
        
        // Secret achievements
        $this->createSecretAchievements();
    }
    
    /**
     * Create achievements related to leveling up
     */
    private function createLevelAchievements(): void
    {
        // Basic level achievements
        Achievement::create([
            'name' => 'Getting Started',
            'description' => 'Reach level 5 in your learning journey',
            'is_secret' => false,
            'image' => 'storage/achievements/level-5.png',
        ]);
        
        Achievement::create([
            'name' => 'Intermediate Learner',
            'description' => 'Reach level 10 in your learning journey',
            'is_secret' => false,
            'image' => 'storage/achievements/level-10.png',
        ]);
        
        Achievement::create([
            'name' => 'Advanced Scholar',
            'description' => 'Reach level 25 in your learning journey',
            'is_secret' => false,
            'image' => 'storage/achievements/level-25.png',
        ]);
        
        Achievement::create([
            'name' => 'Master of Knowledge',
            'description' => 'Reach level 50 in your learning journey',
            'is_secret' => false,
            'image' => 'storage/achievements/level-50.png',
        ]);
    }
    
    /**
     * Create achievements related to badge collection
     */
    private function createBadgeCollectionAchievements(): void
    {
        Achievement::create([
            'name' => 'Badge Collector',
            'description' => 'Collect 5 different badges',
            'is_secret' => false,
            'image' => 'storage/achievements/badge-collector.png',
        ]);
        
        Achievement::create([
            'name' => 'Badge Enthusiast',
            'description' => 'Collect 15 different badges',
            'is_secret' => false,
            'image' => 'storage/achievements/badge-enthusiast.png',
        ]);
        
        Achievement::create([
            'name' => 'Badge Connoisseur',
            'description' => 'Collect 30 different badges',
            'is_secret' => false,
            'image' => 'storage/achievements/badge-connoisseur.png',
        ]);
    }
    
    /**
     * Create achievements related to login streaks
     */
    private function createLoginStreakAchievements(): void
    {
        Achievement::create([
            'name' => 'First Week',
            'description' => 'Log in for 7 consecutive days',
            'is_secret' => false,
            'image' => 'storage/achievements/login-streak-7.png',
        ]);
        
        Achievement::create([
            'name' => 'Dedicated Learner',
            'description' => 'Log in for 30 consecutive days',
            'is_secret' => false,
            'image' => 'storage/achievements/login-streak-30.png',
        ]);
        
        Achievement::create([
            'name' => 'Consistent Scholar',
            'description' => 'Log in for 100 consecutive days',
            'is_secret' => false,
            'image' => 'storage/achievements/login-streak-100.png',
        ]);
        
        Achievement::create([
            'name' => 'Learning Lifestyle',
            'description' => 'Log in for 365 consecutive days',
            'is_secret' => false,
            'image' => 'storage/achievements/login-streak-365.png',
        ]);
    }
    
    /**
     * Create secret achievements that users discover through special actions
     */
    private function createSecretAchievements(): void
    {
        // Secret level achievements
        Achievement::create([
            'name' => 'Level Milestone: 15',
            'description' => 'Hidden achievement for reaching Level 15',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-level-15.png',
        ]);
        
        Achievement::create([
            'name' => 'Level Milestone: 30',
            'description' => 'Hidden achievement for reaching Level 30',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-level-30.png',
        ]);
        
        // Secret login streak achievements
        Achievement::create([
            'name' => 'Weekend Warrior',
            'description' => 'Log in on 10 consecutive weekends',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-weekend-warrior.png',
        ]);
        
        Achievement::create([
            'name' => 'Early Bird',
            'description' => 'Log in before 6:00 AM 5 times',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-early-bird.png',
        ]);
        
        Achievement::create([
            'name' => 'Night Owl',
            'description' => 'Log in after 11:00 PM 5 times',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-night-owl.png',
        ]);
        
        // Secret badge collection achievements
        Achievement::create([
            'name' => 'Badge Perfectionist',
            'description' => 'Collect all badges in a specific category',
            'is_secret' => true,
            'image' => 'storage/achievements/secret-badge-perfectionist.png',
        ]);
    }
}
