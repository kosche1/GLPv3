<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        
        return view('admin.users.management', compact('users', 'roles'));
    }
    
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        
        $user->save();
        
        // Update role
        $role = Role::findById($validated['role']);
        $user->syncRoles([$role]);
        
        return redirect()->route('admin.users.management')->with('success', 'User updated successfully');
    }
}
