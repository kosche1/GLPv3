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
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Create permissions for badges
        Permission::create(['name' => 'view badges']);
        Permission::create(['name' => 'create badges']);
        Permission::create(['name' => 'edit badges']);
        Permission::create(['name' => 'delete badges']);

        // Create permissions for tasks
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);

        // Create permissions for rewards
        Permission::create(['name' => 'view rewards']);
        Permission::create(['name' => 'create rewards']);
        Permission::create(['name' => 'edit rewards']);
        Permission::create(['name' => 'delete rewards']);

        // Create permissions for leaderboards
        Permission::create(['name' => 'view leaderboards']);
        Permission::create(['name' => 'manage leaderboards']);
    }
}
