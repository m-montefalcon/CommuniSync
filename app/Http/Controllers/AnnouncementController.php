<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AnnouncementRequests\UserAnnouncementRequest;

class AnnouncementController extends Controller
{
    public function announcementStore(UserAnnouncementRequest $request){
        $validatedData = $request -> validated();
    
        $validatedData['announcement_date'] = Carbon::now();
        $validatedData['admin_id'] = Auth::user()->id;
        $validatedData['role'] = json_encode($validatedData['role']);
        Announcement::create($validatedData);
    
        return redirect()->route('announcement');
    }

    public function announcementFetchMobile(Request $request){
        $role = $request->input('role');

        // Fetch announcements based on the user's role
        $announcements = Announcement::withRole($role)->with('admin')->get();
        return response()->json($announcements);
    }
}
