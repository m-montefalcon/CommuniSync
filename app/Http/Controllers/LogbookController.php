<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
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

    // Split the full name into an array of names
    $names = explode(' ', $validatedData['full_name']);

    // Use the last name as it is
    $lastName = array_pop($names);

    // Use the remaining names as the first name
    $firstName = implode(' ', $names);

    // Now you can use $firstName and $lastName in your search
    $findHomeowner = User::checkMvo($firstName, $lastName, 2)->first(); // Add ->first()

    if(!$findHomeowner){
        return response()->json(['message' => 'The user does not exist or the manual visit option is disabled'], 403);
    }

    return response()->json(['user' => $findHomeowner], 200);
}


    public function post(Request $request, $id){
        $validatedData = $request->validate([
            'personnel_id' => 'required',
            'contact_number' => 'required',
            'destination_person' => 'required',
            'visit_members' => 'required|array',
        ]);
        $validatedData['visit_date'] = now()->toDateString();
        $validatedData['homeowner_id'] = $id;
        
        $firstNames = [];
        $lastNames = [];
        
        foreach ($validatedData['visit_members'] as $member) {
            [$firstName, $lastName] = explode(' ', $member);
            $firstNames[] = $firstName;
            $lastNames[] = $lastName;
        }
        $validatedData['visit_members'] = json_encode($validatedData['visit_members']);

        $isMemberBlocked = BlockList::memberBlock($firstNames, $lastNames);
        
        if ($isMemberBlocked) {
            return response()->json(['message' => 'The user or a member is blocked and the operation is denied.'], 403);
        }
        
        Logbook::create($validatedData);
        
        return response()->json(['message' => 'success', 'data' => $validatedData], 200);
    }        
    
    
}
