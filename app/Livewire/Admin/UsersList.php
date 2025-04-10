<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersList extends Component
{
    use WithPagination;
    
    public $showEditModal = false;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRole;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|min:8|confirmed',
        'selectedRole' => 'required',
    ];
    
    public function openEditModal($userId)
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        
        // Get the user's current role
        $userRole = $user->roles->first();
        $this->selectedRole = $userRole ? $userRole->id : null;
        
        $this->showEditModal = true;
    }
    
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'selectedRole']);
    }
    
    public function saveUser()
    {
        $this->validate();
        
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->name = $this->name;
            
            // Only update email if it has changed
            if ($user->email !== $this->email) {
                $this->validate([
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                ]);
                $user->email = $this->email;
            }
            
            // Update password if provided
            if (!empty($this->password)) {
                $user->password = bcrypt($this->password);
            }
            
            $user->save();
            
            // Update role
            $role = Role::findById($this->selectedRole);
            $user->syncRoles([$role]);
            
            session()->flash('message', 'User updated successfully!');
        }
        
        $this->closeEditModal();
    }
    
    public function render()
    {
        $users = User::paginate(10);
        $roles = Role::pluck('name', 'id');
        
        return view('livewire.admin.users-list', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
