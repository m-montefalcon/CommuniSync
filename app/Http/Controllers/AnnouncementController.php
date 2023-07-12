<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function show(){
        $announcements = Announcement::all();
        return view('announcement.announcement', compact('announcements'));
    }


    public function announcementStore(Request $request){
        $validatedData = $request->validate([
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_photo' => 'required',
            'announcement_date' => 'required',
            'role' => 'required|array'
        ]);
        

        $announcementRequest = ([
            'announcement_title' => $validatedData['announcement_title'],
            'announcement_description' =>  $validatedData['announcement_description'],
            'announcement_photo' =>  $validatedData['announcement_photo'],
            'announcement_date' =>  $validatedData['announcement_date'],
            'role' => json_encode($validatedData['role']),
            
        ]);
        $announcementPosted = Announcement::create($announcementRequest);
        @dd($announcementPosted);
    }
}
