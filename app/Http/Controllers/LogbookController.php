<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\BlockList;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class LogbookController extends Controller
{
    public function get(Request $request){
        $validatedData = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
        ]);
        $findHomeowner = User::where('first_name', $validatedData['first_name'])
                                ->where('last_name', $validatedData['last_name'])
                                ->where('role', 2)
                                ->where('manual_visit_option', 1)
                                ->get();


       

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
            'contact_number' => 'required'
        ]);
        $validatedData['visit_members'] = json_encode($validatedData['visit_members']);
        $validatedData['visit_date'] = now()->toDateString();
        $validatedData['homeowner_id'] = $id;
    
    
        foreach (json_decode($validatedData['visit_members'], true) as $member) {
            list($firstName, $lastName) = explode(' ', $member);
            $isBlocked = BlockList::where('first_name', $firstName)
                ->where('last_name', $lastName)
                ->first();
    
            if ($isBlocked) {
                return response()->json(['message' => 'The user or a member is blocked and the operation is denied.'], 403);
            }
        }
    
        Logbook::create($validatedData);
    
        return response()->json(['message' => 'success', 'data' => $validatedData], 200);
    }
    
    
}
