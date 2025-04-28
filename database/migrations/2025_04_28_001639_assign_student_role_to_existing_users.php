<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get users without any role
        $usersWithoutRoles = DB::table('users')
            ->whereNotIn('id', function($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->where('model_type', 'App\\Models\\User');
            })
            ->get();

        // Get the student role
        $studentRole = Role::where('name', 'student')->first();

        if (!$studentRole) {
            // Create the student role if it doesn't exist
            $studentRole = Role::create(['name' => 'student', 'guard_name' => 'web']);
        }

        // Assign the student role to users without roles
        foreach ($usersWithoutRoles as $userData) {
            $user = User::find($userData->id);
            if ($user) {
                $user->assignRole($studentRole);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as we can't determine which users
        // had no roles before this migration was run
    }
};
