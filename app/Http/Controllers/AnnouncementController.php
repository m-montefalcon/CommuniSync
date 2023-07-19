<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function show(){
        $announcements = Announcement::all();
        return view('announcement.announcement', compact('announcements'));
    }

    public function create(){
        return view('announcement.announcementForm');
    }

    public function announcementStore(Request $request){
        $validatedData = $request->validate([
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_photo' => ['required', 'nullable'],
            'announcement_date' => 'required',
            'role' => 'required|array'
        ]);
        
        $user = Auth::user(); // Get the authenticated user
        $announcementRequest = ([
            'announcement_title' => $validatedData['announcement_title'],
            'announcement_description' =>  $validatedData['announcement_description'],
            'announcement_photo' =>  $validatedData['announcement_photo'],
            'announcement_date' =>  $validatedData['announcement_date'],
            'role' => json_encode($validatedData['role']),
            'created_by' => $user->id, 
            
        ]);
        $announcementPosted = Announcement::create($announcementRequest);
        return redirect()->route('announcement');

    }

    public function announcementFetchMobile(Request $request){
        $role = $request->input('role');

        // Fetch announcements based on the user's role
        $announcements = Announcement::whereJsonContains('role', $role)->get();
    
        return response()->json($announcements);
    }
}
