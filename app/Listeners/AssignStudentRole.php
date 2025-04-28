<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class AssignStudentRole
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // Get the student role
        $studentRole = Role::where('name', 'student')->first();
        
        if ($studentRole) {
            // Assign the student role to the newly registered user
            $event->user->assignRole($studentRole);
        }
    }
}
