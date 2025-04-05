<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Announcements',
                'description' => 'Official announcements and important updates',
                'color' => '#10b981', // emerald-500
                'order' => 1,
            ],
            [
                'name' => 'General Discussion',
                'description' => 'Discuss any topic related to programming and development',
                'color' => '#3b82f6', // blue-500
                'order' => 2,
            ],
            [
                'name' => 'Questions & Help',
                'description' => 'Ask questions and get help from the community',
                'color' => '#8b5cf6', // violet-500
                'order' => 3,
            ],
            [
                'name' => 'Resources',
                'description' => 'Share useful resources, tutorials, and tools',
                'color' => '#f59e0b', // amber-500
                'order' => 4,
            ],
            [
                'name' => 'Showcase',
                'description' => 'Show off your projects and get feedback',
                'color' => '#ec4899', // pink-500
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ForumCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'color' => $category['color'],
                'order' => $category['order'],
                'is_active' => true,
            ]);
        }
    }
}
