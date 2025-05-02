<?php

namespace Database\Seeders;

use App\Models\Strand;
use App\Models\SubjectType;
use Illuminate\Database\Seeder;

class StrandAndSubjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Subject Types
        $subjectTypes = [
            [
                'name' => 'Core Subjects',
                'code' => 'core',
                'description' => 'Fundamental subjects that form the foundation of education.',
                'color' => '#10B981', // Emerald-500
                'icon' => 'heroicon-o-academic-cap',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Applied Subjects',
                'code' => 'applied',
                'description' => 'Subjects that apply theoretical knowledge to practical scenarios.',
                'color' => '#3B82F6', // Blue-500
                'icon' => 'heroicon-o-beaker',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Specialized Subjects',
                'code' => 'specialized',
                'description' => 'Advanced subjects focused on specific career tracks.',
                'color' => '#8B5CF6', // Violet-500
                'icon' => 'heroicon-o-sparkles',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($subjectTypes as $subjectType) {
            SubjectType::updateOrCreate(
                ['code' => $subjectType['code']],
                $subjectType
            );
        }

        // Create Strands
        $strands = [
            [
                'name' => 'HUMMS',
                'code' => 'humms',
                'full_name' => 'Humanities and Social Sciences',
                'description' => 'Focuses on literature, philosophy, social sciences, and cultural studies for future social workers, educators, and legal professionals.',
                'color' => '#8B5CF6', // Violet-500
                'icon' => 'heroicon-o-user-group',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'STEM',
                'code' => 'stem',
                'full_name' => 'Science, Technology, Engineering, and Mathematics',
                'description' => 'Prepares students for careers in research, engineering, healthcare, and advanced technology fields.',
                'color' => '#10B981', // Emerald-500
                'icon' => 'heroicon-o-beaker',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'ABM',
                'code' => 'abm',
                'full_name' => 'Accountancy, Business, and Management',
                'description' => 'Focuses on fundamental concepts of financial management, business operations, and corporate governance.',
                'color' => '#F59E0B', // Amber-500
                'icon' => 'heroicon-o-currency-dollar',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'ICT',
                'code' => 'ict',
                'full_name' => 'Information and Communications Technology',
                'description' => 'Focuses on computer programming, systems development, networking, and digital media for future IT professionals.',
                'color' => '#3B82F6', // Blue-500
                'icon' => 'heroicon-o-computer-desktop',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'HE',
                'code' => 'he',
                'full_name' => 'Home Economics',
                'description' => 'Provides specialized training in hospitality, tourism, food and beverage services, and consumer education.',
                'color' => '#EC4899', // Pink-500
                'icon' => 'heroicon-o-home',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($strands as $strand) {
            Strand::updateOrCreate(
                ['code' => $strand['code']],
                $strand
            );
        }

        $this->command->info('Subject Types and Strands seeded successfully!');
    }
}
