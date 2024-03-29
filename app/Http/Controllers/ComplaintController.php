<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Services\ComplaintService;
use App\Events\NewNotificationEvent;
use Illuminate\Support\Facades\Auth;
use App\Console\Commands\NotificationService;
use Illuminate\Contracts\Support\ValidatedData;
use App\Http\Requests\Complaints\UserComplaintStoreRequest;
use App\Http\Requests\Complaints\UserComplaintUpdateRequest;

class ComplaintController extends Controller
{
    protected $notificationService;
    protected $complaintService;

    public function __construct(NotificationService $notificationService, ComplaintService $complaintService)
    {
        $this->notificationService = $notificationService;
        $this->complaintService = $complaintService;

    }
    
    public function storeMobile(UserComplaintStoreRequest $request,  NotificationsController $notificationController){
        $validatedData = $request -> validated();
        $imagePath = null;
        if ($request->hasFile('complaint_photo')) {
            $imagePath = $request->file('complaint_photo')->store('complaints', 'public');
        }
        
        $validatedData['complaint_photo'] = $imagePath;

        $validatedData['complaint_date'] = now()->toDateString();
        $validatedData['complaint_status'] = 1;
        // @dd($validatedData);

        $title = 'Complaint Submitted!';
        $body = 'Complaint was successfully submitted. Please wait for the admin to opened it';
        $id = $validatedData['homeowner_id'];
        $this->notificationService->sendNotificationById($id, $title, $body);
        Complaint::create($validatedData);
        // Create and broadcast the new notification

        $notification = $notificationController->createNotificationByRoles('New complaint', 'New complaint has received, check it under Complaints Tab.', 4);
        broadcast(new NewNotificationEvent($notification))->toOthers();
    
        return response()->json(['data' => $validatedData], 200);

    }


    public function update(UserComplaintUpdateRequest $request, Complaint $id,NotificationsController $notificationController)
    {
        $validatedData = $request->validated();

    
        // Retrieve the complaint record and check if it exists
        if (!$id) {
            return response()->json(['error' => 'Complaint not found'], 404);
        }
    
        // Decode the existing complaint updates or initialize an empty array
        $existingUpdates = json_decode($id->complaint_updates, true) ?? [];
    
        // Append the new update to the existing updates array
        // Append the new update to the existing updates array
        $existingUpdates[] = [
            'update' => $validatedData['complaint_updates'][0], // Assuming the update is a single string value
            'date' => now()->toDateString(),
        ];

    
        // Encode the updated complaint updates to JSON
        $encodedUpdates = json_encode($existingUpdates);
       

        // Update the complaint record with the validated data and encoded updates
        $id->update([
            'complaint_updates' => $encodedUpdates,
            'complaint_status' => 2,
            'complaint_date' => now()->toDateString(),
            'admin_id' =>  Auth::id()
        ]);
       
        $admin = User::find(Auth::id());

        $title = 'Complaint opened by Admin';
        $body = "Complaint was opened and reviewed by {$admin->first_name} {$admin->last_name}. Check the following updates";
        $id = $id->homeowner_id;

        $this->notificationService->sendNotificationById($id, $title, $body);
        $notificationController->createNotificationById($title, $body, $id);

        return redirect()->back();
    }
    
  
    public function close(UserComplaintUpdateRequest $request, Complaint $id, NotificationsController $notificationController)
    {
        $validatedData = $request->validated();
    
        // Retrieve the complaint record and check if it exists
        if (!$id) {
            return response()->json(['error' => 'Complaint not found'], 404);
        }
    
        // Decode the existing complaint updates or initialize an empty array
        $existingUpdates = json_decode($id->complaint_updates, true) ?? [];
    
        // Add the new update to the existing updates array
        $existingUpdates[] = [
            'resolution' => $validatedData['complaint_updates'][0],
            'date' => now()->toDateString(),
        ];
    
        // Encode the updated complaint updates to JSON
        $encodedUpdates = json_encode($existingUpdates);
    
        // Validate the complaint status and date
        $validatedData['complaint_status'] = 3;
        $validatedData['complaint_date'] = now()->toDateString();
    
        // Update the complaint record with the validated data and encoded updates
        $id->update([
            'complaint_updates' => $encodedUpdates,
            'complaint_status' => $validatedData['complaint_status'],
            'complaint_date' => $validatedData['complaint_date'],
            'admin_id' =>  Auth::id()

        ]);
        $admin = User::find(Auth::id());

        $title = 'Complaint close with resolution by Admin';
        $body = "Complaint was closed and resolved by {$admin->first_name} {$admin->last_name}. Check the following updates";
        $id = $id->homeowner_id;

        $this->notificationService->sendNotificationById($id, $title, $body);
        $notificationController->createNotificationById($title, $body, $id);

        return redirect()->back();
    }
    
    
    public function fetchByHomeowner($id) {
        $fetchALlComplaints = Complaint::with('admin')
            ->where('homeowner_id', $id)
            ->whereIn('complaint_status', [1, 2, 3])
            ->latest('complaint_date') // Order by creation date in descending order
            ->get();
    
        return response()->json(['data' => $fetchALlComplaints], 200);
    }
    
    
    public function dashboardFetchByHomeowner($id) {
        $fetchLatestComplaints = Complaint::with('admin')
            ->fetchAllComplaintsByHomeowner($id)
            ->sortByDesc('complaint_date')
            ->take(2);
    
        return response()->json(['data' => $fetchLatestComplaints->values()], 200);
    }
    
    public function newPdfForm(Request $request)
    {
        $id = $request->input('id');

        // Generate and show the PDF using the service
        $this->complaintService->generateAndShowPdfInNewTab($id);
    
        // Redirect back
        return redirect()->back();

    }
    

    public function historyPdfForm(Request $request){
        $id = $request->input('id');
        $this->complaintService->historyGenerateAndShowPdfInNewTab($id);

        return redirect()->back();

    }
    
    
    
    
}
