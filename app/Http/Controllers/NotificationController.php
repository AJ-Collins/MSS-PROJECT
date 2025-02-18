<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $notifications = auth()->user()->notifications()
            ->orWhere('data->user_reg_no', auth()->user()->reg_no)
            ->orderBy('created_at', 'desc')
            ->paginate(10)  // Paginate results
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'user_reg_no' => $notification->notifiable->reg_no,
                    'message' => $notification->data['message'] ?? '',
                    'link' => $notification->data['link'] ?? '#',
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            });

        $unreadCount = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        try {
            // Mark all unread notifications for the authenticated user as read
            auth()->user()->unreadNotifications->markAsRead();

            return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
        } catch (\Exception $e) {
            \Log::error('Error marking notifications as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to mark notifications as read'], 500);
        }
    }
}