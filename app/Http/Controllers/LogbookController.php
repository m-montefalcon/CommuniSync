<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    //Logbook will record when Visitor will out
    public function out(Logbook $id){
        $logbookEntry = Logbook::find($id);
    
        // Check if the logbookEntry exists
        if (!$logbookEntry) {
            return response()->json(['message' => 'Logbook entry not found'], 404);
        }
    
        // Update logbook entry when visitor leaves
        $currentDateTime = now();
        $logbookEntry->visit_status = 2; // Set visit_status to 2 when the visitor leaves
        $logbookEntry->visit_date_out = $currentDateTime->toDateString();
        $logbookEntry->visit_time_out = $currentDateTime->toTimeString();
        $logbookEntry->save();
    
        return response()->json(['message' => 'Visitor has left. Logbook updated.'], 200);
    }

    public function checkOut(){
        $fetchRequests = Logbook::with('visitor')->with('homeowner')
            ->where('logbook_status', 1)
            ->get();
    
        return response(['data' => $fetchRequests], 200);
    }
    
    


    public function get(Request $request){
        $validatedData = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
        ]);
        
        $findHomeowner = User::checkMvo($validatedData['first_name'], $validatedData['last_name'], 2);
        if(!$findHomeowner){
            return response()->json(['message' => 'The user does not exist'], 403);

        }

        // $isMvoOn = $findHomeowner->manual_visit_option;
    
        // @dd( $isMvoOn );
        
        return response()->json(['message' => 'Info', $findHomeowner , 200]);

    }

    public function post(Request $request, $id){
        $validatedData = $request->validate([
            'personnel_id' => 'required',
            'contact_number' => 'required',
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
