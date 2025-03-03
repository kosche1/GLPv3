<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create faculty users
        $faculty1 = User::factory()->create([
            'name' => 'Faculty One',
            'email' => 'faculty1@example.com',
            'password' => Hash::make('password'),
        ]);
        $faculty1->assignRole('faculty');

        $faculty2 = User::factory()->create([
            'name' => 'Faculty Two',
            'email' => 'faculty2@example.com',
            'password' => Hash::make('password'),
        ]);
        $faculty2->assignRole('faculty');

        // Create regular student user for testing
        $student = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
        ]);
        $student->assignRole('student');

        // Create additional student users
        User::factory(20)->create()->each(function ($user) {
            $user->assignRole('student');
        });
    }
}
