<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = \App\Models\Notification::where('user_id', $user->id);

        // Filter by type if provided
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by read status if provided
        if ($request->has('status')) {
            if ($request->status === 'read') {
                $query->where('read', true);
            } elseif ($request->status === 'unread') {
                $query->where('read', false);
            }
        }

        $notifications = $query->latest()->paginate(10)->withQueryString();

        // Get unique notification types for the filter dropdown
        $types = \App\Models\Notification::where('user_id', $user->id)
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->toArray();

        return view('notifications', compact('notifications', 'types'));
    }

    /**
     * Get the user's notifications as JSON for the dashboard.
     */
    public function getNotifications()
    {
        $user = Auth::user();

        // Get all notifications from the database
        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->latest()
            ->limit(20) // Increased limit to ensure we have enough after filtering
            ->get();

        // Map the notifications to the format expected by the frontend
        $mappedNotifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->message,
                'time' => $notification->getFormattedTimeAttribute(),
                'read' => (bool)$notification->read,
                'type' => $notification->type,
                'link' => $notification->link,
            ];
        });

        // Filter out duplicate notifications based on message and type
        $uniqueNotifications = collect();
        $seenMessages = [];

        foreach ($mappedNotifications as $notification) {
            $key = $notification['message'] . '|' . $notification['type'];
            if (!in_array($key, $seenMessages)) {
                $seenMessages[] = $key;
                $uniqueNotifications->push($notification);
            }
        }

        // Limit to 10 notifications after filtering
        $uniqueNotifications = $uniqueNotifications->take(10);

        return response()->json($uniqueNotifications);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = \App\Models\Notification::where('user_id', $user->id)->findOrFail($id);
        $notification->markAsRead();

        // If the request wants JSON, return JSON response
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // Otherwise redirect back with a success message
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        \App\Models\Notification::where('user_id', $user->id)->update(['read' => true]);

        // If the request wants JSON, return JSON response
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // Otherwise redirect back with a success message
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }


}