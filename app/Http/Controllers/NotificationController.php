<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Create and send a notification to a client or user
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable|exists:clients,id', // Optional if sending to a user
            'user_id' => 'nullable|exists:users,id',   // Optional if sending to a client
            'title' => 'required|string|max:255',     // Add a title for the notification
            'message' => 'required|string',           // Notification message
        ]);

        if (!$request->client_id && !$request->user_id) {
            return response()->json(['error' => 'Either client_id or user_id must be provided'], 400);
        }

        try {
            $notification = new Notification();
            $notification->client_id = $request->client_id;
            $notification->user_id = $request->user_id;
            $notification->title = $request->title;
            $notification->message = $request->message;
            $notification->save();

            return response()->json(['message' => 'Notification sent successfully', 'notification' => $notification]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'details' => $e->getMessage()], 500);
        }
    }

    // Retrieve notifications for a specific client or user
    public function index(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if (!$request->client_id && !$request->user_id) {
            return response()->json(['error' => 'Either client_id or user_id must be provided'], 400);
        }

        try {
            $notifications = Notification::query()
                ->when($request->client_id, fn($query) => $query->where('client_id', $request->client_id))
                ->when($request->user_id, fn($query) => $query->where('user_id', $request->user_id))
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['notifications' => $notifications]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve notifications', 'details' => $e->getMessage()], 500);
        }
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->is_read = true;
            $notification->save();

            return response()->json(['message' => 'Notification marked as read', 'notification' => $notification]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to mark notification as read', 'details' => $e->getMessage()], 500);
        }
    }
}
