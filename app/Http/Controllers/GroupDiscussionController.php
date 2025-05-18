<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\GroupDiscussion;
use App\Models\GroupDiscussionComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GroupDiscussionController extends Controller
{
    /**
     * Display a listing of the discussions for a study group.
     */
    public function index(StudyGroup $studyGroup): View
    {
        $user = Auth::user();
        
        // Check if user is a member or if the group is public
        if (!$studyGroup->hasMember($user) && $studyGroup->is_private) {
            abort(403, 'You are not a member of this private study group.');
        }
        
        // Get discussions for this study group
        $discussions = $studyGroup->discussions()
            ->with('user')
            ->withCount('comments')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('study-groups.discussions.index', [
            'studyGroup' => $studyGroup,
            'discussions' => $discussions,
            'userRole' => $studyGroup->getMemberRole($user),
        ]);
    }

    /**
     * Show the form for creating a new discussion.
     */
    public function create(StudyGroup $studyGroup): View
    {
        $user = Auth::user();
        
        // Check if user is a member
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        return view('study-groups.discussions.create', [
            'studyGroup' => $studyGroup,
        ]);
    }

    /**
     * Store a newly created discussion.
     */
    public function store(Request $request, StudyGroup $studyGroup)
    {
        $user = Auth::user();
        
        // Check if user is a member
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        // Create the discussion
        $discussion = new GroupDiscussion();
        $discussion->study_group_id = $studyGroup->id;
        $discussion->user_id = $user->id;
        $discussion->title = $request->title;
        $discussion->content = $request->content;
        $discussion->is_pinned = false;
        
        $discussion->save();
        
        return redirect()->route('study-groups.discussions.show', [
            'studyGroup' => $studyGroup,
            'discussion' => $discussion,
        ])->with('success', 'Discussion created successfully!');
    }

    /**
     * Display the specified discussion.
     */
    public function show(StudyGroup $studyGroup, GroupDiscussion $discussion): View
    {
        $user = Auth::user();
        
        // Check if user is a member or if the group is public
        if (!$studyGroup->hasMember($user) && $studyGroup->is_private) {
            abort(403, 'You are not a member of this private study group.');
        }
        
        // Check if the discussion belongs to the study group
        if ($discussion->study_group_id !== $studyGroup->id) {
            abort(404, 'Discussion not found in this study group.');
        }
        
        // Load relationships
        $discussion->load(['user', 'rootComments.user', 'rootComments.replies.user']);
        
        return view('study-groups.discussions.show', [
            'studyGroup' => $studyGroup,
            'discussion' => $discussion,
            'userRole' => $studyGroup->getMemberRole($user),
        ]);
    }

    /**
     * Show the form for editing the discussion.
     */
    public function edit(StudyGroup $studyGroup, GroupDiscussion $discussion): View
    {
        $user = Auth::user();
        
        // Check if user is the author or a moderator
        if ($discussion->user_id !== $user->id && !$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit this discussion.');
        }
        
        // Check if the discussion belongs to the study group
        if ($discussion->study_group_id !== $studyGroup->id) {
            abort(404, 'Discussion not found in this study group.');
        }
        
        return view('study-groups.discussions.edit', [
            'studyGroup' => $studyGroup,
            'discussion' => $discussion,
        ]);
    }

    /**
     * Update the specified discussion.
     */
    public function update(Request $request, StudyGroup $studyGroup, GroupDiscussion $discussion)
    {
        $user = Auth::user();
        
        // Check if user is the author or a moderator
        if ($discussion->user_id !== $user->id && !$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to edit this discussion.');
        }
        
        // Check if the discussion belongs to the study group
        if ($discussion->study_group_id !== $studyGroup->id) {
            abort(404, 'Discussion not found in this study group.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        // Update the discussion
        $discussion->title = $request->title;
        $discussion->content = $request->content;
        
        // Only moderators can pin/unpin discussions
        if ($studyGroup->isModerator($user) && $request->has('is_pinned')) {
            $discussion->is_pinned = $request->is_pinned ? true : false;
        }
        
        $discussion->save();
        
        return redirect()->route('study-groups.discussions.show', [
            'studyGroup' => $studyGroup,
            'discussion' => $discussion,
        ])->with('success', 'Discussion updated successfully!');
    }

    /**
     * Toggle pin status of a discussion.
     */
    public function togglePin(StudyGroup $studyGroup, GroupDiscussion $discussion)
    {
        $user = Auth::user();
        
        // Check if user is a moderator
        if (!$studyGroup->isModerator($user)) {
            abort(403, 'You do not have permission to pin/unpin discussions.');
        }
        
        // Check if the discussion belongs to the study group
        if ($discussion->study_group_id !== $studyGroup->id) {
            abort(404, 'Discussion not found in this study group.');
        }
        
        // Toggle pin status
        $discussion->is_pinned = !$discussion->is_pinned;
        $discussion->save();
        
        $action = $discussion->is_pinned ? 'pinned' : 'unpinned';
        
        return redirect()->back()->with('success', "Discussion {$action} successfully!");
    }

    /**
     * Add a comment to a discussion.
     */
    public function addComment(Request $request, StudyGroup $studyGroup, GroupDiscussion $discussion)
    {
        $user = Auth::user();
        
        // Check if user is a member
        if (!$studyGroup->hasMember($user)) {
            abort(403, 'You are not a member of this study group.');
        }
        
        // Check if the discussion belongs to the study group
        if ($discussion->study_group_id !== $studyGroup->id) {
            abort(404, 'Discussion not found in this study group.');
        }
        
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:group_discussion_comments,id',
        ]);
        
        // Create the comment
        $comment = new GroupDiscussionComment();
        $comment->group_discussion_id = $discussion->id;
        $comment->user_id = $user->id;
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        
        $comment->save();
        
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
