<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Information Technology',
                'description' => 'General IT and computer science related challenges',
                'slug' => 'information-technology',
            ],
            [
                'name' => 'Web Development',
                'description' => 'Web development and programming challenges',
                'slug' => 'web-development',
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Mobile app development challenges',
                'slug' => 'mobile-development',
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Security and ethical hacking challenges',
                'slug' => 'cybersecurity',
            ],
            [
                'name' => 'Data Science',
                'description' => 'Data analysis and machine learning challenges',
                'slug' => 'data-science',
            ],
            [
                'name' => 'DevOps',
                'description' => 'Development operations and infrastructure challenges',
                'slug' => 'devops',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}