<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for current user/role
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? null;
        
        $notifications = Notification::where(function($query) use ($user, $role) {
            $query->where('user_id', $user->id)
                  ->orWhere('role', $role)
                  ->orWhereNull('role');
        })
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get();
        
        $unreadCount = Notification::where(function($query) use ($user, $role) {
            $query->where('user_id', $user->id)
                  ->orWhere('role', $role)
                  ->orWhereNull('role');
        })
        ->unread()
        ->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $role = $user->role ?? null;
        
        Notification::where(function($query) use ($user, $role) {
            $query->where('user_id', $user->id)
                  ->orWhere('role', $role)
                  ->orWhereNull('role');
        })
        ->unread()
        ->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        return response()->json(['success' => true]);
    }
}
