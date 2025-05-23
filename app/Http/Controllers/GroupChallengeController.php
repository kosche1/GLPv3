<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\GroupChallenge;
use App\Models\GroupChallengeTask;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GroupChallengeController extends Controller
{
    /**
     * Show the form for creating a new group challenge.
     */
    public function create(StudyGroup $studyGroup): View
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to create challenges for this study group.');
        }
        
        // Get categories for the form
        $categories = Category::all();
        
        return view('study-groups.challenges.create', [
            'studyGroup' => $studyGroup,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created group challenge.
     */
    public function store(Request $request, StudyGroup $studyGroup)
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to create challenges for this study group.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'points_reward' => 'required|integer|min:0',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'category_id' => 'nullable|exists:categories,id',
            'challenge_type' => 'nullable|string|max:255',
            'time_limit' => 'nullable|integer|min:0',
            'challenge_content' => 'nullable|string',
        ]);
        
        // Create the group challenge
        $groupChallenge = new GroupChallenge();
        $groupChallenge->name = $request->name;
        $groupChallenge->description = $request->description;
        $groupChallenge->study_group_id = $studyGroup->id;
        $groupChallenge->created_by = $user->id;
        $groupChallenge->start_date = $request->start_date;
        $groupChallenge->end_date = $request->end_date;
        $groupChallenge->points_reward = $request->points_reward;
        $groupChallenge->difficulty_level = $request->difficulty_level;
        $groupChallenge->is_active = true;
        $groupChallenge->category_id = $request->category_id;
        $groupChallenge->challenge_type = $request->challenge_type;
        $groupChallenge->time_limit = $request->time_limit;
        $groupChallenge->challenge_content = $request->challenge_content;
        
        $groupChallenge->save();
        
        return redirect()->route('study-groups.challenges.show', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
        ])->with('success', 'Group challenge created successfully!');
    }

    /**
     * Display the specified group challenge.
     */
    public function show(StudyGroup $studyGroup, GroupChallenge $groupChallenge): View
    {
        $user = Auth::user();
        
        // Check if user is a member of the study group
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        // Check if the challenge belongs to the study group
        if ($groupChallenge->study_group_id !== $studyGroup->id) {
            abort(404, 'Challenge not found in this study group.');
        }
        
        // Load relationships
        $groupChallenge->load(['creator', 'category', 'tasks', 'participants']);
        
        // Get user's progress in this challenge
        $userProgress = $groupChallenge->participants()
            ->where('user_id', $user->id)
            ->first();
        
        return view('study-groups.challenges.show', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
            'userProgress' => $userProgress,
            'userRole' => $studyGroup->getMemberRole($user),
        ]);
    }

    /**
     * Show the form for editing the group challenge.
     */
    public function edit(StudyGroup $studyGroup, GroupChallenge $groupChallenge): View
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit challenges for this study group.');
        }
        
        // Check if the challenge belongs to the study group
        if ($groupChallenge->study_group_id !== $studyGroup->id) {
            abort(404, 'Challenge not found in this study group.');
        }
        
        // Get categories for the form
        $categories = Category::all();
        
        return view('study-groups.challenges.edit', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified group challenge.
     */
    public function update(Request $request, StudyGroup $studyGroup, GroupChallenge $groupChallenge)
    {
        $user = Auth::user();
        
        // Check if user is a leader or moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit challenges for this study group.');
        }
        
        // Check if the challenge belongs to the study group
        if ($groupChallenge->study_group_id !== $studyGroup->id) {
            abort(404, 'Challenge not found in this study group.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'points_reward' => 'required|integer|min:0',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'challenge_type' => 'nullable|string|max:255',
            'time_limit' => 'nullable|integer|min:0',
            'challenge_content' => 'nullable|string',
        ]);
        
        // Update the group challenge
        $groupChallenge->name = $request->name;
        $groupChallenge->description = $request->description;
        $groupChallenge->start_date = $request->start_date;
        $groupChallenge->end_date = $request->end_date;
        $groupChallenge->points_reward = $request->points_reward;
        $groupChallenge->difficulty_level = $request->difficulty_level;
        $groupChallenge->is_active = $request->is_active ?? false;
        $groupChallenge->category_id = $request->category_id;
        $groupChallenge->challenge_type = $request->challenge_type;
        $groupChallenge->time_limit = $request->time_limit;
        $groupChallenge->challenge_content = $request->challenge_content;
        
        $groupChallenge->save();
        
        return redirect()->route('study-groups.challenges.show', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
        ])->with('success', 'Group challenge updated successfully!');
    }

    /**
     * Join a group challenge.
     */
    public function join(StudyGroup $studyGroup, GroupChallenge $groupChallenge)
    {
        $user = Auth::user();
        
        // Check if user is a member of the study group
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        // Check if the challenge belongs to the study group
        if ($groupChallenge->study_group_id !== $studyGroup->id) {
            abort(404, 'Challenge not found in this study group.');
        }
        
        // Check if the challenge is active
        if (!$groupChallenge->isActive()) {
            return redirect()->back()->with('error', 'This challenge is not currently active.');
        }
        
        // Check if user is already participating
        if ($groupChallenge->participants()->where('user_id', $user->id)->exists()) {
            return redirect()->route('study-groups.challenges.show', [
                'studyGroup' => $studyGroup,
                'groupChallenge' => $groupChallenge,
            ])->with('info', 'You are already participating in this challenge.');
        }
        
        // Add user as a participant
        $groupChallenge->participants()->attach($user->id, [
            'status' => 'in_progress',
            'progress' => 0,
            'attempts' => 1,
        ]);
        
        return redirect()->route('study-groups.challenges.show', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
        ])->with('success', 'You have joined the challenge successfully!');
    }

    /**
     * Update user's progress in a group challenge.
     */
    public function updateProgress(Request $request, StudyGroup $studyGroup, GroupChallenge $groupChallenge)
    {
        $user = Auth::user();
        
        // Check if user is a member of the study group
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        // Check if the challenge belongs to the study group
        if ($groupChallenge->study_group_id !== $studyGroup->id) {
            abort(404, 'Challenge not found in this study group.');
        }
        
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);
        
        // Check if user is participating
        $userProgress = $groupChallenge->participants()->where('user_id', $user->id)->first();
        
        if (!$userProgress) {
            return redirect()->back()->with('error', 'You are not participating in this challenge.');
        }
        
        // Update progress
        $progress = $request->progress;
        $status = $progress >= 100 ? 'completed' : 'in_progress';
        $completedAt = $progress >= 100 ? now() : null;
        
        $groupChallenge->participants()->updateExistingPivot($user->id, [
            'status' => $status,
            'progress' => $progress,
            'completed_at' => $completedAt,
        ]);
        
        // Award points if completed
        if ($progress >= 100 && $userProgress->pivot->status !== 'completed') {
            $user->addPoints(
                $groupChallenge->points_reward,
                reason: "Completed group challenge: {$groupChallenge->name}"
            );
        }
        
        return redirect()->route('study-groups.challenges.show', [
            'studyGroup' => $studyGroup,
            'groupChallenge' => $groupChallenge,
        ])->with('success', 'Your progress has been updated successfully!');
    }
}
