<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use App\Notifications\FriendRequestSent;
use App\Services\RealTimeService;

class FriendshipController extends Controller
{
    protected $realTimeService;

    public function __construct(RealTimeService $realTimeService)
    {
        $this->realTimeService = $realTimeService;
    }

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
            ->get()
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

        if (!$friendship) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to send friend request. You may already be friends or have a pending request.'
            ], 400);
        }

        // The friendship was created successfully. Prepare the success response.
        $response = response()->json([
            'success' => true,
            'message' => 'Friend request sent successfully!'
        ]);

        // Now, attempt to send the notification. A failure here will be logged
        // but will not prevent the success response from being sent.
        try {
            Notification::send($targetUser, new FriendRequestSent($user));
            // Also broadcast real-time notification
            $this->realTimeService->broadcastFriendRequest($user, $targetUser);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send friend request notification: ' . $e->getMessage());
        }

        return $response;
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
            // Broadcast friend request acceptance
            $this->realTimeService->broadcastFriendRequestAccepted($user, $requester);

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
     * Cancel a friend request.
     */
    public function cancelRequest(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = Auth::user();
        $targetUser = User::findOrFail($request->user_id);

        $deleted = $user->cancelFriendRequestTo($targetUser);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Friend request canceled.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Friend request not found or could not be canceled.'
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
     * Get friends by status (online, offline, all).
     */
    public function getFriendsByStatus(Request $request): JsonResponse
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');

        $friends = $user->friends();

        // Add status information to all friends
        $friendsWithStatus = $friends->map(function ($friend) {
            $minutesAgo = $friend->last_activity_at ?
                         $friend->last_activity_at->diffInMinutes(now()) : null;

            $friend->status = $this->getFriendStatus($minutesAgo);
            $friend->last_activity_description = $this->getLastActivityDescription($friend);
            $friend->activity_time = $friend->last_activity_at ?
                                   $friend->last_activity_at->diffForHumans() : 'Unknown';

            return $friend;
        });

        // Filter by status if requested
        if ($status === 'online') {
            $friendsWithStatus = $friendsWithStatus->filter(function ($friend) {
                return $friend->status === 'online';
            });
        } elseif ($status === 'offline') {
            $friendsWithStatus = $friendsWithStatus->filter(function ($friend) {
                return $friend->status !== 'online'; // Include 'active' and 'away' statuses
            });
        }

        // Sort by status priority and name
        $friendsWithStatus = $friendsWithStatus->sortBy(function ($friend) {
            $statusPriority = ['online' => 1, 'active' => 2, 'away' => 3];
            return ($statusPriority[$friend->status] ?? 4) . $friend->name;
        })->values();

        return response()->json([
            'friends' => $friendsWithStatus->map(function ($friend) {
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
     * Get pending friend requests (sent and received).
     */
    public function getPendingRequests(): JsonResponse
    {
        $user = Auth::user();

        $sentRequests = $user->sentFriendRequests()
            ->pending()
            ->with('friend')
            ->get()
            ->map(function ($friendship) {
                return [
                    'id' => $friendship->friend->id,
                    'name' => $friendship->friend->name,
                    'initials' => $friendship->friend->initials(),
                    'level' => $friendship->friend->getLevel(),
                    'points' => $friendship->friend->getPoints(),
                    'type' => 'sent',
                    'created_at' => $friendship->created_at->diffForHumans()
                ];
            });

        $receivedRequests = $user->receivedFriendRequests()
            ->pending()
            ->with('user')
            ->get()
            ->map(function ($friendship) {
                return [
                    'id' => $friendship->user->id,
                    'name' => $friendship->user->name,
                    'initials' => $friendship->user->initials(),
                    'level' => $friendship->user->getLevel(),
                    'points' => $friendship->user->getPoints(),
                    'type' => 'received',
                    'created_at' => $friendship->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'sent_requests' => $sentRequests,
            'received_requests' => $receivedRequests
        ]);
    }

    /**
     * Helper method to get friend status.
     */
    private function getFriendStatus($minutesAgo)
    {
        if ($minutesAgo === null) return 'away';
        if ($minutesAgo <= 5) return 'online';
        if ($minutesAgo <= 15) return 'active';
        return 'away';
    }

    /**
     * Helper method to get last activity description.
     */
    private function getLastActivityDescription($friend)
    {
        if (!$friend->last_activity_at) {
            return 'No recent activity';
        }

        $minutesAgo = $friend->last_activity_at->diffInMinutes(now());

        if ($minutesAgo <= 1) {
            return 'Active now';
        } elseif ($minutesAgo <= 5) {
            return 'Active recently';
        } elseif ($minutesAgo <= 15) {
            return 'Active ' . $minutesAgo . ' minutes ago';
        } else {
            return 'Last seen ' . $friend->last_activity_at->diffForHumans();
        }
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
                'bio' => $friend->bio,
                'skills' => $friend->skills ? explode(',', $friend->skills) : [],
                'last_activity_at' => $friend->last_activity_at?->diffForHumans(),
                'badges_count' => $friend->badges()->count(),
                'achievements_count' => $friend->achievements()->count(),
            ]
        ]);
    }

    /**
     * Get real-time messages for the authenticated user.
     */
    public function getRealTimeMessages(): JsonResponse
    {
        $user = Auth::user();
        $cacheKey = "user_messages_{$user->id}";
        $messages = \Illuminate\Support\Facades\Cache::get($cacheKey, []);

        // Clear messages after retrieving them
        \Illuminate\Support\Facades\Cache::forget($cacheKey);

        return response()->json([
            'messages' => $messages
        ]);
    }

    /**
     * Get online friends for the authenticated user.
     */
    public function getOnlineFriends(): JsonResponse
    {
        $user = Auth::user();
        $onlineFriends = $this->realTimeService->getOnlineFriends($user);

        return response()->json([
            'friends' => $onlineFriends
        ]);
    }

    /**
     * Debug endpoint to check friend status calculation.
     */
    public function debugFriendStatus(): JsonResponse
    {
        $user = Auth::user();
        $friends = $user->friends();

        $debugInfo = $friends->map(function ($friend) {
            $minutesAgo = $friend->last_activity_at ?
                         $friend->last_activity_at->diffInMinutes(now()) : null;

            return [
                'id' => $friend->id,
                'name' => $friend->name,
                'last_activity_at' => $friend->last_activity_at?->toISOString(),
                'last_activity_human' => $friend->last_activity_at?->diffForHumans(),
                'minutes_ago' => $minutesAgo,
                'calculated_status' => $this->getFriendStatus($minutesAgo),
                'current_time' => now()->toISOString(),
            ];
        });

        return response()->json([
            'debug_info' => $debugInfo,
            'current_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'last_activity_at' => $user->last_activity_at?->toISOString(),
                'last_activity_human' => $user->last_activity_at?->diffForHumans(),
            ]
        ]);
    }
}
