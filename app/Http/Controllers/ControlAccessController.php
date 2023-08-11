<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlockList;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ControlAccessController extends Controller
{
    //SEARCH THE HOMEOWNER ONLY
    public function searchMobile(Request $request)
    {
        try {
            $username = $request->input('username');
            $users = User::where('user_name', 'LIKE', "%{$username}%")
                         ->where('role', 2)
                         ->get();

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error'], 500);
        }
    }


    //REQUEST ACCESS VISITOR ONLY
    public function requestMobile(Request $request){
       
        $validatedData = $request->validate([
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'destination_person' => ['required'],
            'visit_members' => ['nullable', 'array'],
        ]);
    
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $validatedData['visit_members'] = json_encode($validatedData['visit_members']);
        
        // $findAdminName = User::find($validatedData['id']);
        // $validatedData['admin_name']= $findAdminName-> first_name . ' ' . $findAdminName-> last_name;
        
        $findHomeownerName = User::find($validatedData['homeowner_id']);
        $validatedData['homeowner_name'] = $findHomeownerName->first_name . ' ' . $findHomeownerName->last_name;
    
        $findVisitorName = User::find($validatedData['visitor_id']);
        $validatedData['visitor_name'] = $findVisitorName->first_name . ' ' . $findVisitorName->last_name;
    
        ControlAccess::create($validatedData);
    
        return response()->json(['request success' => true, $validatedData], 200);
       
    }

    //HOMEOWNER ACCEPT TO VISITOR
    public function acceptMobile(Request $request){
        $validatedData = $request->validate([
            'id' => ['required', 'integer']
        ]);

        $id = ControlAccess::find($validatedData['id']);
        $validatedData['visit_status'] = 2;
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        // @dd($validatedData);
        $id->update($validatedData);

        return response()->json(['accepted' => true], 200);
    }


    //ADMIN VALIDATES THE REQUEST
    public function validated(ControlAccess $id){
        $validatedData['visit_status'] = 3;
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $id->update($validatedData);

    
        $adminId = Auth::user();
        $adminName = $adminId-> first_name . ' ' . $adminId->last_name;
        

        
        $dataToEncode = [
            'ID' => $id->id,
            'Visitor ID' => $id->visitor_id,
            'Visitor Name' =>  $id->visitor_name,
            'Homeowner ID' => $id->homeowner_id,
            'Homeowner Name' => $id->homeowner_name,
            'Admin ID' => $adminId->id,
            'Admin Name' => $adminName,
            'Date' => Carbon::now()->toDateString(),
            'Time' =>Carbon::now()->toTimeString(),
            'Destination' => $id->destination_person,
            'Visit Members' => $id->visit_members,
            'Visit Status' => $id->visit_status
        ];

        // @dd( $dataToEncode);
       // Encode data array as JSON
        $jsonToEncode = json_encode($dataToEncode);

        $qrCode = QrCode::encoding('UTF-8')->size(300)->generate($jsonToEncode);
        $id->qr_code = $qrCode;
        $id->save();
        return response()->json(['qr_code' => $dataToEncode],  200);
    }


    public function recordedMobile(Request $request){
        $validatedData = $request->validate([
            'id' => ['required', 'integer'],
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'admin_id' => ['required', 'integer'],
            'personnel_id' => ['required', 'integer'],
            'visit_members' => ['required', 'array'],
        ]);

        $controlAccessId = ControlAccess::find($validatedData['id']);
        
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        
        $findPersonnelName = User::find($validatedData['homeowner_id']);
        $personnelName = $findPersonnelName->first_name . ' ' . $findPersonnelName->last_name;
        $validatedData['personnel_name'] = $personnelName;


        $visitor = User::find($validatedData['visitor_id']);


        $isVisitorBlocked = BlockList::where('user_name', $visitor->user_name)
        ->orWhere(function($query) use ($visitor) {
            $query->where('first_name', $visitor->first_name)
                  ->where('last_name', $visitor->last_name);
        })
        ->orWhere('contact_number', $visitor->contact_number)
        ->first();

        $visit_members = $validatedData['visit_members'];

        foreach($visit_members as $member){
            list($firstName, $lastName) = explode(' ', $member);
            $isMemberBlocked = BlockList::where('first_name', $firstName)
                ->where('last_name', $lastName)
                ->first();
        
            // If a blocked member is found, break the loop
            
        }

        if ($isVisitorBlocked) {
            $validatedData['visit_status'] = 5;
            $controlAccessId->update($validatedData);
            return response()->json(['message' => 'The user is blocked and the operation is denied.'], 403);
        }

        if ($isMemberBlocked) {
            $validatedData['visit_status'] = 5;
            $controlAccessId->update($validatedData);
            return response()->json(['message' => 'A member is blocked and the operation is denied.'], 403);
        }
        $validatedData['visit_status'] = 4;
        $controlAccessId->update($validatedData);
    
        return response()->json(['scanned' => true], 200);
    }


    public function fetchAllRequestMobile($id){
        $fetchRequests = ControlAccess::where('homeowner_id', $id)->get();
    
        if ($fetchRequests->count() > 0){
            return response()->json(['message' => "Query Success", 'data' => $fetchRequests], 200);
        } else {
            return response()->json(['message' => "No Request"], 403);
        }
    }
    
   

}
