<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification; // Fix the namespace here

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
    public function createNotificationById($title, $body, $id)
    {
        $notification = Notification::create([ // Fix the model name here
            'title' => $title,
            'body' => $body,
            'recipient_id' => $id,
            'is_hovered' => false
        ]);


        return $notification;
    }


    public function fetchNotificationByRoles()
        {
            $role = 4; // Set the role you want to fetch notifications for

            $notifications = Notification::where('role', $role)->where('is_hovered', false)->get();

            return response()->json(['notifications' => $notifications], 200);
        }

    public function fetchNotificationById($id){

            $notifications = Notification::where('recipient_id', $id)->where('is_hovered', false)
            ->orderBy('created_at', 'desc')
            ->get();
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

    public function markAllAsReadMobile(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
        ]);
        // Assuming you have a `notifications` table in your database
        Notification::where('recipient_id', $validatedData['id'])
            ->update(['is_hovered' => true]);

        return response()->json(['message' => 'All notifications marked as read']);
    }

}
