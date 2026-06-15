<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserNotification::where('user_id', auth()->id());

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(10)->withQueryString();

        $unreadCount = UserNotification::where('user_id', auth()->id())->where('status', 'unread')->count();

        if (auth()->user()->hasRole('patient')) {
            return view('patient.notifications.index', compact('notifications', 'unreadCount'));
        }

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function show(UserNotification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if ($notification->status === 'unread') {
            $notification->update(['status' => 'read']);
        }

        return response()->json([
            'success' => true,
            'notification' => $notification,
        ]);
    }

    public function markRead(UserNotification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $notification->update(['status' => 'read']);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    public function markUnread(UserNotification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $notification->update(['status' => 'unread']);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as unread.',
        ]);
    }

    public function archive(UserNotification $notification): JsonResponse
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $notification->update(['status' => 'archived']);

        return response()->json([
            'success' => true,
            'message' => 'Notification archived.',
        ]);
    }

    public function markAllRead(): JsonResponse
    {
        UserNotification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }

    public function getUnreadCount(): JsonResponse
    {
        $count = UserNotification::where('user_id', auth()->id())->where('status', 'unread')->count();

        return response()->json(['count' => $count]);
    }
}
