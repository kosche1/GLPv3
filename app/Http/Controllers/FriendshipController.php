<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FriendshipController extends Controller
{
    /**
     * Display the friends management page.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        $friends = $user->friends();
        $pendingRequests = $user->getPendingFriendRequests();
        $activeFriends = $user->getActiveFriends();
        
        return view('friends.index', compact('friends', 'pendingRequests', 'activeFriends'));
    }

    /**
     * Search for users to add as friends.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $user = Auth::user();
        
        if (strlen($query) < 2) {
            return response()->json(['users' => []]);
        }
        
        $users = User::where('name', 'like', "%{$query}%")
            ->where('id', '!=', $user->id)
            ->whereDoesntHave('sentFriendRequests', function ($q) use ($user) {
                $q->where('friend_id', $user->id);
            })
            ->whereDoesntHave('receivedFriendRequests', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->limit(10)
            ->get(['id', 'name', 'email'])
            ->map(function ($searchUser) use ($user) {
                return [
                    'id' => $searchUser->id,
                    'name' => $searchUser->name,
                    'email' => $searchUser->email,
                    'initials' => $searchUser->initials(),
                    'level' => $searchUser->getLevel(),
                    'points' => $searchUser->getPoints(),
                    'is_friend' => $user->isFriendsWith($searchUser),
                    'request_sent' => $user->hasSentFriendRequestTo($searchUser),
                    'request_received' => $user->hasReceivedFriendRequestFrom($searchUser),
                ];
            });
        
        return response()->json(['users' => $users]);
    }

    /**
     * Send a friend request.
     */
    public function sendRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        $targetUser = User::findOrFail($request->user_id);
        
        $friendship = $user->sendFriendRequestTo($targetUser);
        
        if ($friendship) {
            return response()->json([
                'success' => true,
                'message' => 'Friend request sent successfully!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unable to send friend request. You may already be friends or have a pending request.'
        ], 400);
    }

    /**
     * Accept a friend request.
     */
    public function acceptRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        $requester = User::findOrFail($request->user_id);
        
        $accepted = $user->acceptFriendRequestFrom($requester);
        
        if ($accepted) {
            return response()->json([
                'success' => true,
                'message' => 'Friend request accepted!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unable to accept friend request.'
        ], 400);
    }

    /**
     * Decline a friend request.
     */
    public function declineRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        
        $friendship = $user->receivedFriendRequests()
            ->where('user_id', $request->user_id)
            ->pending()
            ->first();
        
        if ($friendship) {
            $friendship->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Friend request declined.'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Friend request not found.'
        ], 400);
    }

    /**
     * Remove a friend.
     */
    public function removeFriend(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        $friendUser = User::findOrFail($request->user_id);
        
        // Remove friendship in both directions
        $user->sentFriendRequests()
            ->where('friend_id', $friendUser->id)
            ->delete();
            
        $user->receivedFriendRequests()
            ->where('user_id', $friendUser->id)
            ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Friend removed successfully.'
        ]);
    }

    /**
     * Get active friends for dashboard.
     */
    public function getActiveFriends(): JsonResponse
    {
        $user = Auth::user();
        $activeFriends = $user->getActiveFriends();
        
        return response()->json([
            'friends' => $activeFriends->map(function ($friend) {
                return [
                    'id' => $friend->id,
                    'name' => $friend->name,
                    'initials' => $friend->initials(),
                    'level' => $friend->getLevel(),
                    'status' => $friend->status,
                    'last_activity' => $friend->last_activity_description,
                    'activity_time' => $friend->activity_time,
                    'points' => $friend->getPoints()
                ];
            })
        ]);
    }

    /**
     * Get friend profile information.
     */
    public function getFriendProfile($userId): JsonResponse
    {
        $user = Auth::user();
        $friend = User::findOrFail($userId);
        
        // Check if they are friends
        if (!$user->isFriendsWith($friend)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not friends with this user.'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'friend' => [
                'id' => $friend->id,
                'name' => $friend->name,
                'initials' => $friend->initials(),
                'level' => $friend->getLevel(),
                'points' => $friend->getPoints(),
                'last_activity_at' => $friend->last_activity_at?->diffForHumans(),
                'badges_count' => $friend->badges()->count(),
                'achievements_count' => $friend->achievements()->count(),
                'challenges_completed' => $friend->challenges()
                    ->wherePivot('status', 'completed')
                    ->count(),
            ]
        ]);
    }
}
