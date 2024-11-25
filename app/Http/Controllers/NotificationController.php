<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification; // Fixed typo in model name
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnreadNotifications()
    {
        $notifications = UserNotification::where('is_read', false)
            ->get();

        return response()->json($notifications);
    }
    
    public function markAsRead($notificationId)
    {
        $notification = UserNotification::where('id', $notificationId) // Fixed typo
            ->where('user_id', Auth::id())
            ->first();
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }
        return response()->json(['success' => true]);
    }
}
