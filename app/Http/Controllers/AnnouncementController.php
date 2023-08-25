<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function announcementStore(Request $request){
        $validatedData = $request->validate([
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_photo' => ['required', 'nullable'],
            'role' => 'required|array'
        ]);
    
        $validatedData['announcement_date'] = Carbon::now();
        $validatedData['admin_id'] = Auth::user()->id;
    
        Announcement::create($validatedData);
    
        return redirect()->route('announcement');
    }

    public function announcementFetchMobile(Request $request){
        $role = $request->input('role');

        // Fetch announcements based on the user's role
        $announcements = Announcement::with('user')->whereJsonContains('role', [$role])->get();
        return response()->json($announcements);
    }
}
