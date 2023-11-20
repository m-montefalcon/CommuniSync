<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Console\Commands\NotificationService;
use App\Http\Requests\AnnouncementRequests\UserAnnouncementRequest;

class AnnouncementController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function announcementStore(UserAnnouncementRequest $request)
    {
        $validatedData = $request->validated();
    
        $imagePath = null;
        if ($request->hasFile('announcement_photo')) {
            $imagePath = $request->file('announcement_photo')->store('announcement', 'public');
        }
        
        $validatedData['announcement_photo'] = $imagePath;
        $validatedData['announcement_date'] = Carbon::now();
        $validatedData['admin_id'] = auth()->user()->id;
        $validatedData['role'] = json_encode($validatedData['role']);
    // @dd($validatedData);
        Announcement::create($validatedData);
        $title = 'ANNOUNCEMENT';
        $body = $validatedData['announcement_title'];
        $roles = json_decode($validatedData['role'], true);
        $this->notificationService->sendNotificationByRoles($roles, $title, $body);

        return redirect()->route('announcement');
    }

    public function announcementFetchMobile($id){
       

        // Fetch announcements based on the user's role
        $announcements = Announcement::withRole($id)->with('admin')->get();
        return response()->json(['data' => $announcements], 200);
    }
}
