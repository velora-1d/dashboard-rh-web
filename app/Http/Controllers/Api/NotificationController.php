<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Get user's notifications based on role
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role; // Assuming role property exists on user

        $query = Notification::query()
            ->where(function($q) use ($user, $role) {
                $q->where('user_id', $user->id)
                  ->orWhere('role', $role)
                  ->orWhereNull('role');
            })
            ->orderBy('created_at', 'desc');

        $notifications = $query->take(50)->get();

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read for current user
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $role = $user->role;

        Notification::where(function($q) use ($user, $role) {
                $q->where('user_id', $user->id)
                  ->orWhere('role', $role);
            })
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }
}
