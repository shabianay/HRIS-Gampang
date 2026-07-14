<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->limit(10)
            ->get();

        $unreadCount = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }
}
