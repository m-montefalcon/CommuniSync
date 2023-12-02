<?php

namespace App\Http\Controllers;

use App\Models\Notification; // Fix the namespace here
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function createNotificationByRoles($title, $body, $roles)
    {
        $notification = Notification::create([ // Fix the model name here
            'title' => $title,
            'body' => $body,
            'role' => $roles,
            'is_hovered' => false

        ]);

        // You can add additional logic here, such as broadcasting an event if needed.

        return $notification;
    }

    public function fetchNotificationByRoles()
        {
            $role = 4; // Set the role you want to fetch notifications for

            $notifications = Notification::where('role', $role)->where('is_hovered', false)->get();

            return response()->json(['notifications' => $notifications], 200);
        }

    public function updateIsHoveredForAll(Request $request)
    {
        try {
            // Update the is_hovered status for all notifications
            Notification::where('role', 4)->update(['is_hovered' => $request->input('is_hovered', true)]);

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            // Handle the exception if needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function markAsRead($id)
    {
        try {
            // Update the is_hovered status for the specified notification
            $notification = Notification::find($id);
            if ($notification) {
                $notification->update(['is_hovered' => true]);
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['error' => 'Notification not found'], 404);
            }
        } catch (\Exception $e) {
            // Handle the exception if needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
