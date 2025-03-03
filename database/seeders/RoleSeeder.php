<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $facultyRole = Role::create(['name' => 'faculty']);
        $facultyRole->givePermissionTo([
            'view users', 'view badges', 'view tasks', 'view rewards', 'view leaderboards',
            'create tasks', 'edit tasks', 'delete tasks',
            'create rewards', 'edit rewards', 'delete rewards',
            'manage leaderboards',
        ]);

        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view badges', 'view tasks', 'view rewards', 'view leaderboards',
        ]);
    }
}
