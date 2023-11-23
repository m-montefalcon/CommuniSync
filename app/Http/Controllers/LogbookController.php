<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use Illuminate\Http\Request;
use App\Console\Commands\NotificationService;

class LogbookController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    //Logbook will record when Visitor will out
    public function out($id) {
        // Find the logbook entry by ID
        $logbookEntry = Logbook::find($id);
    
        // Check if the logbookEntry exists
        if (!$logbookEntry) {
            return response()->json(['message' => 'Logbook entry not found'], 404);
        }
    
        // Update logbook entry when visitor leaves
        $currentDateTime = now();
        $logbookEntry->logbook_status = 2; // Set visit_status to 2 when the visitor leaves
        $logbookEntry->visit_date_out = $currentDateTime->toDateString();
        $logbookEntry->visit_time_out = $currentDateTime->toTimeString();
        
        // Retrieve the visitor's contact number using Eloquent relationships
        $visitor = $logbookEntry->visitor; // Assuming 'visitor' is the relationship method
    
        // Check if the visitor and contact number exist
        if ($visitor && !empty($visitor->contact_number)) {
            $logbookEntry->contact_number = $visitor->contact_number;
        }
        $logbookEntry->save();
      
        $id =  $logbookEntry->homeowner_id;
        $title = 'Control Access';
        $body = 'Visitor has successfully exited the subdivision.';
        $this->notificationService->sendNotificationById($id, $title, $body);
        return response()->json(['message' => 'Visitor has left. Logbook updated.'], 200);
    }
    
    

    public function checkOut(){
        $fetchRequests = Logbook::with('visitor')->with('homeowner')
            ->where('logbook_status', 1)
            ->get();
    
        return response(['data' => $fetchRequests], 200);
    }
    
    


public function checkIfMvoOn(Request $request){
    $validatedData = $request->validate([
        "full_name" => "required", // Update the validation to use full_name
    ]);

    // Get the full name from the request
    $fullName = $validatedData['full_name'];

    // Use the full name in your search query with the new scope function
    $findHomeowner = User::checkMvoPartial($fullName, 2)->get();

    if(!$findHomeowner){
        return response()->json(['message' => 'The user does not exist or the manual visit option is disabled'], 403);
    }

    return response()->json(['user' => $findHomeowner], 200);
}


    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'homeowner_id' => 'required',
            'personnel_id' => 'required',
            'contact_number' => 'required',
            'destination_person' => 'required',
            'visit_members' => 'required',
        ]);
        
        $validatedData['visit_date'] = now()->toDateString();
        
        $visitMembers = json_decode($validatedData['visit_members'], true);
        
        $currentDateTime = now();
        $validatedData['visit_date_in'] = $currentDateTime->toDateString();
        $validatedData['visit_time_in'] = $currentDateTime->toTimeString();
        
        // Use the model's scope directly
        $isMemberBlocked = BlockList::memberBlock($visitMembers);

        if ($isMemberBlocked) {
            return response()->json(['message' => 'The user or a member is blocked, and the operation is denied.'], 403);
        }

        // Update the visit_members field with the processed array
        $validatedData['visit_members'] = json_encode($visitMembers);

        // Create logbook entry
        Logbook::create($validatedData);

        // Send notification
        $namesString = implode(', ', $visitMembers);
        $id = $validatedData['homeowner_id'];
        $title = 'Control Access';
        $body = "Visitors namely: $namesString, have been approved to visit you. They are on their way!";

        $this->notificationService->sendNotificationById($id, $title, $body);

        return response()->json(['message' => 'success', 'data' => $validatedData], 200);
    }

    
}
