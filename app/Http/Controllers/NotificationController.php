<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnreadNotifications()
    {
        $users = User::all();
        $notifications = UserNotification::with(['user'])
            ->where('is_read', false)
            ->whereIn('user_id', $users->pluck('id'))
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'notification_type' => $notification->notification_type,
                    'notification_message' => $notification->notification_message,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at,
                    'user_id' => $notification->user_id, // Add user_id here
                    'admin_user_id' => $notification->user ? $notification->user->name : 'Unknown User',
                    'user_name' => $notification->user ? $notification->user->name : 'Unknown User'
                ];
            });

        return response()->json($notifications);
    }

    public function getNotificationCountsAdminDashboard()
    {
        $counts = UserNotification::where('is_read', false)
            ->select('user_id')
            ->groupBy('user_id')
            ->selectRaw('count(*) as count, user_id')
            ->pluck('count', 'user_id');

        return response()->json($counts);
    }
    
    public function markAsRead($notificationId)
    {
        UserNotification::where('id', $notificationId)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
}
