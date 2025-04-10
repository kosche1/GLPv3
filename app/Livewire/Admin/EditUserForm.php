<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EditUserForm extends Component
{
    public User $user;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRole;
    public $availableRoles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|min:8|confirmed',
        'selectedRole' => 'required',
    ];

    public function mount($userId = null)
    {
        $this->userId = $userId;

        // Load available roles
        $this->availableRoles = Role::pluck('name', 'id')->toArray();

        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->name = $this->user->name;
            $this->email = $this->user->email;

            // Get the user's current role
            $userRole = $this->user->roles->first();
            $this->selectedRole = $userRole ? $userRole->id : null;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // Validate the form
        $this->validate();

        if ($this->userId) {
            // Update existing user
            $this->user->name = $this->name;

            // Only update email if it has changed
            if ($this->user->email !== $this->email) {
                $this->validate([
                    'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
                ]);
                $this->user->email = $this->email;
            }

            // Update password if provided
            if (!empty($this->password)) {
                $this->user->password = Hash::make($this->password);
            }

            $this->user->save();

            // Update role
            $role = Role::findById($this->selectedRole);
            $this->user->syncRoles([$role]);

            session()->flash('message', 'User updated successfully!');
        } else {
            // Create new user
            $this->validate([
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Assign role
            $role = Role::findById($this->selectedRole);
            $user->assignRole($role);

            session()->flash('message', 'User created successfully!');
        }

        // Reset form
        $this->reset(['password', 'password_confirmation']);

        // Emit event to close modal
        $this->dispatch('userSaved');
    }

    public function render()
    {
        return view('livewire.admin.edit-user-form');
    }
}
