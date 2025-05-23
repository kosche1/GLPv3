<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\GroupChallenge;
use App\Models\GroupDiscussion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudyGroupController extends Controller
{
    /**
     * Display a listing of study groups.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get the user's study groups
        $myGroups = $user->studyGroups()->with('creator')->get();
        
        // Get public study groups the user is not a member of
        $publicGroups = StudyGroup::where('is_private', false)
            ->whereDoesntHave('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('creator')
            ->withCount('members')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get categories for filtering
        $categories = Category::all();
        
        return view('study-groups.index', [
            'myGroups' => $myGroups,
            'publicGroups' => $publicGroups,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new study group.
     */
    public function create(): View
    {
        // Get categories for the form
        $categories = Category::all();
        
        return view('study-groups.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created study group.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
            'max_members' => 'required|integer|min:2|max:50',
            'focus_areas' => 'nullable|array',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Create the study group
        $studyGroup = new StudyGroup();
        $studyGroup->name = $request->name;
        $studyGroup->description = $request->description;
        $studyGroup->created_by = Auth::id();
        $studyGroup->is_private = $request->is_private ?? false;
        $studyGroup->max_members = $request->max_members;
        $studyGroup->focus_areas = $request->focus_areas;
        
        // Generate join code for private groups
        if ($studyGroup->is_private) {
            $studyGroup->join_code = StudyGroup::generateJoinCode();
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('study-groups', 'public');
            $studyGroup->image = $path;
        }
        
        $studyGroup->save();
        
        // Add the creator as a member with leader role
        $studyGroup->members()->attach(Auth::id(), [
            'role' => 'leader',
            'joined_at' => now(),
        ]);
        
        return redirect()->route('study-groups.show', $studyGroup)
            ->with('success', 'Study group created successfully!');
    }

    /**
     * Display the specified study group.
     */
    public function show(StudyGroup $studyGroup): View
    {
        $user = Auth::user();
        
        // Check if user is a member or if the group is public
        if (!$studyGroup->hasMember($user) && $studyGroup->is_private) {
            abort(403, 'You are not a member of this private study group.');
        }
        
        // Load relationships
        $studyGroup->load(['creator', 'members', 'groupChallenges', 'discussions']);
        
        // Get the user's role in the group
        $userRole = $studyGroup->getMemberRole($user);
        
        return view('study-groups.show', [
            'studyGroup' => $studyGroup,
            'userRole' => $userRole,
        ]);
    }

    /**
     * Show the form for editing the study group.
     */
    public function edit(StudyGroup $studyGroup): View
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit this study group.');
        }
        
        // Get categories for the form
        $categories = Category::all();
        
        return view('study-groups.edit', [
            'studyGroup' => $studyGroup,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified study group.
     */
    public function update(Request $request, StudyGroup $studyGroup)
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit this study group.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
            'max_members' => 'required|integer|min:2|max:50',
            'focus_areas' => 'nullable|array',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);
        
        // Update the study group
        $studyGroup->name = $request->name;
        $studyGroup->description = $request->description;
        $studyGroup->is_private = $request->is_private ?? false;
        $studyGroup->max_members = $request->max_members;
        $studyGroup->focus_areas = $request->focus_areas;
        
        // Generate join code for private groups if it doesn't exist
        if ($studyGroup->is_private && !$studyGroup->join_code) {
            $studyGroup->join_code = StudyGroup::generateJoinCode();
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($studyGroup->image) {
                Storage::disk('public')->delete($studyGroup->image);
            }
            
            $path = $request->file('image')->store('study-groups', 'public');
            $studyGroup->image = $path;
        }
        
        $studyGroup->save();
        
        return redirect()->route('study-groups.show', $studyGroup)
            ->with('success', 'Study group updated successfully!');
    }

    /**
     * Join a study group.
     */
    public function join(Request $request)
    {
        $user = Auth::user();
        
        if ($request->has('join_code')) {
            // Join by code
            $request->validate([
                'join_code' => 'required|string|exists:study_groups,join_code',
            ]);
            
            $studyGroup = StudyGroup::where('join_code', $request->join_code)->firstOrFail();
        } else {
            // Join by ID (public group)
            $request->validate([
                'study_group_id' => 'required|exists:study_groups,id',
            ]);
            
            $studyGroup = StudyGroup::findOrFail($request->study_group_id);
            
            // Check if the group is private
            if ($studyGroup->is_private) {
                return redirect()->back()->with('error', 'This is a private group. Please use a join code to join.');
            }
        }
        
        // Check if user is already a member
        if ($studyGroup->hasMember($user)) {
            return redirect()->route('study-groups.show', $studyGroup)
                ->with('info', 'You are already a member of this study group.');
        }
        
        // Check if the group is full
        if ($studyGroup->isFull()) {
            return redirect()->back()->with('error', 'This study group is full.');
        }
        
        // Add user as a member
        $studyGroup->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);
        
        return redirect()->route('study-groups.show', $studyGroup)
            ->with('success', 'You have joined the study group successfully!');
    }

    /**
     * Leave a study group.
     */
    public function leave(StudyGroup $studyGroup)
    {
        $user = Auth::user();
        
        // Check if user is a member
        if (!$studyGroup->hasMember($user)) {
            return redirect()->back()->with('error', 'You are not a member of this study group.');
        }
        
        // Check if user is the only leader
        if ($studyGroup->isLeader($user) && 
            $studyGroup->members()->wherePivot('role', 'leader')->count() <= 1) {
            return redirect()->back()->with('error', 'You cannot leave the group as you are the only leader. Please promote another member to leader first or delete the group.');
        }
        
        // Remove user from the group
        $studyGroup->members()->detach($user->id);
        
        return redirect()->route('study-groups.index')
            ->with('success', 'You have left the study group successfully.');
    }
}
