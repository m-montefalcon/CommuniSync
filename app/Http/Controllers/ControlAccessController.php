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
    public function requestMobile(Request $request) 
    {
        $validatedData = $request->validate([
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'destination_person' => ['required'],
            'visit_members' => ['nullable', 'array'],
        ]);
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $validatedData['visit_members'] = $request->filled('visit_members') ? json_encode($validatedData['visit_members']) : null;
        ControlAccess::create($validatedData);
        return response()->json(['request success' => true, $validatedData], 200);
    }

    //HOMEOWNER ACCEPT TO VISITOR
    public function acceptMobile(Request $request) 
    {
        $validatedData = $request->validate([
            'id' => ['required', 'integer']
        ]);
        $id = ControlAccess::findOrFail($validatedData['id']);
        $validatedData['visit_status'] = 2;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $id->update($validatedData);
        return response()->json(['accepted' => true, 'id' => $id], 200);
    }
    


    //ADMIN VALIDATES THE REQUEST
    public function validated(ControlAccess $id)
    {
        $adminId = Auth::id();
        // Update the model with the validated data
        $id->update([
            'visit_status' => 3,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_id' => $adminId 
        ]);
        $dataToEncode = [
            'ID' => $id->id,
        ];
        $jsonToEncode = json_encode($dataToEncode);
        // Update the qr_code field and save the model
        $id->qr_code = QrCode::encoding('UTF-8')->size(300)->generate($jsonToEncode);
        $id->save();
        return response()->json(['qr_code' => $id],  200);
    }


    public function recordedMobile(Request $request)
    {
        $validatedData = $request->validate([
            'id' => ['required', 'integer'],
            'personnel_id' => ['required', 'integer']
        ]);
    
        $controlAccessId = ControlAccess::findOrFail($validatedData['id']);
        $visitor = User::findOrFail($controlAccessId->visitor_id);
    
        $isVisitorBlocked = BlockList::where('user_name', $visitor->user_name)
            ->orWhere(function ($query) use ($visitor) {
                $query->where('first_name', $visitor->first_name)
                    ->where('last_name', $visitor->last_name);
            })
            ->orWhere('contact_number', $visitor->contact_number)
            ->first();
    
        $visit_members = json_decode($controlAccessId->visit_members, true);
        $isMemberBlocked = false;
    
        foreach ($visit_members as $member) {
            list($firstName, $lastName) = explode(' ', $member);
            $isBlocked = BlockList::where('first_name', $firstName)
                ->where('last_name', $lastName)
                ->first();
    
            if ($isBlocked) {
                $isMemberBlocked = true;
                break;
            }
        }
    
        $visit_status = ($isVisitorBlocked || $isMemberBlocked) ? 5 : 4;
    
        $currentDate = now()->toDateString();
        $currentTime = now()->toTimeString();
    
        $controlAccessId->update([
            'date' => $currentDate,
            'time' => $currentTime,
            'visit_status' => $visit_status,
            'personnel_id' => $validatedData['personnel_id']
        ]);
    
        if ($visit_status == 5) {
            return response()->json(['message' => 'The user or a member is blocked and the operation is denied.'], 403);
        }
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


    public function fetchSpecificRequestMobile($id){
        $fetchSpecificRequest = ControlAccess::find($id);
        if($fetchSpecificRequest){
            return response(['message' => 'success', $fetchSpecificRequest]);
        }
    }
    
   

}
