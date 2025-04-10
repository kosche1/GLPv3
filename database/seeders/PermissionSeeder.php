<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for users
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // Create permissions for badges
        Permission::firstOrCreate(['name' => 'view badges']);
        Permission::firstOrCreate(['name' => 'create badges']);
        Permission::firstOrCreate(['name' => 'edit badges']);
        Permission::firstOrCreate(['name' => 'delete badges']);

        // Create permissions for tasks
        Permission::firstOrCreate(['name' => 'view tasks']);
        Permission::firstOrCreate(['name' => 'create tasks']);
        Permission::firstOrCreate(['name' => 'edit tasks']);
        Permission::firstOrCreate(['name' => 'delete tasks']);

        // Create permissions for rewards
        Permission::firstOrCreate(['name' => 'view rewards']);
        Permission::firstOrCreate(['name' => 'create rewards']);
        Permission::firstOrCreate(['name' => 'edit rewards']);
        Permission::firstOrCreate(['name' => 'delete rewards']);

        // Create permissions for leaderboards
        Permission::firstOrCreate(['name' => 'view leaderboards']);
        Permission::firstOrCreate(['name' => 'manage leaderboards']);
    }
}
