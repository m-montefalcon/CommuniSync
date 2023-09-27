<?php

namespace App\Http\Controllers;

use App\Http\Requests\ControlAccess\SpCheckIdRequest;
use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Session\TokenMismatchException;
use App\Http\Requests\ControlAccess\UserAccessRequest;
use App\Http\Requests\ControlAccess\UserRecordControlAccessRequest;
use App\Http\Requests\ControlAccess\UserRequestControllAccessRequest;


class ControlAccessController extends Controller
{
    public function getRequestHomeowner($id){
        $fetchRequests = ControlAccess::with('visitor')->fetchRequests($id);
        return response(['data' => $fetchRequests], 200);
    }

    public function getValidatedRequestVisitor($id){
        $fetchRequests = ControlAccess::with('homeowner', 'admin')->getAllValidatedRequest($id);
        return response(['data' => $fetchRequests], 200);

    }
    //SEARCH THE HOMEOWNER ONLY
    public function searchMobile(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',      
        ]);
    
        try {
            $username = $validatedData['username'];
            $users = User::checksRoleWithUsername($username, 2);

            return response()->json([$users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }


    //REQUEST ACCESS VISITOR ONLY
    public function requestMobile(UserRequestControllAccessRequest $request) 
    {
        $validatedData = $request->validated();
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $controlAccess = ControlAccess::create($validatedData);

        return response()->json(['request success' => true, 'data' => $controlAccess], 200);
    }

    //HOMEOWNER ACCEPT TO VISITOR
    public function acceptMobile(UserAccessRequest $request) 
    {
    
        $validatedData = $request->validated();
        $id = ControlAccess::findOrFail($validatedData['id']);
        $validatedData['visit_status'] = 2;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $id->update($validatedData);
        return response()->json(['accepted' => true, 'id' => $id], 200);
    }
    
    public function declineMobile(UserAccessRequest $request){
        $validatedData = $request->validated();
        $id = ControlAccess::findOrFail($validatedData['id']);
        $validatedData['visit_status'] = 3;
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
            'visit_status' => 4,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_id' => $adminId 
        ]);
        $dataToEncode = [
            'ID' => $id->id,
            'Homeowner' => $id->homeowner_id,
            'Visitor'=> $id->visitor_id
        ];
        $jsonToEncode = json_encode($dataToEncode);
        // Update the qr_code field and save the model
        $id->qr_code = QrCode::encoding('UTF-8')->size(300)->generate($jsonToEncode);
        $id->save();
        return redirect()->back();
    }

    public function rejected($id){
        $Rejectedid = ControlAccess::findOrFail($id);
        $adminId = Auth::id();
        // Update the model with the validated data
        $Rejectedid->update([
            'visit_status' => 5,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_id' => $adminId 
        ]);
        $Rejectedid->save();
        return redirect()->back();
    }
    public function rejectedMobile(UserRecordControlAccessRequest $request){
        $validatedData = $request->validated();
        $id = ControlAccess::findOrFail($validatedData['id']);
        $id ->update([
            'visit_status' => 5,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'personnel_id' => $validatedData['personnel_id'] 
        ]);
        $id ->save();
        return response()->json(['Message' => 'Successfully Rejected'], 200);
    }

    public function recordedCheckMobile(SpCheckIdRequest $request){
        $validatedData = $request->validated();
        $returnCheckQr = ControlAccess::with('visitor')->checkQr($validatedData['id'], $validatedData['homeowner_id'],$validatedData['visitor_id']);
        if($returnCheckQr){
            return response()->json(['data' => $returnCheckQr], 200);

        }
        else{
            return response()->json(['data' => 'not found'], 404);

        }
    }

    public function recordedMobile(UserRecordControlAccessRequest $request){
        $validatedData = $request->validated();
        
        $controlAccessId = ControlAccess::findOrFail($validatedData['id']);
        $visitor = User::findOrFail($controlAccessId->visitor_id);

        $isVisitorBlocked = BlockList::visitorBlocked($visitor)->first();


        $visit_members = json_decode($controlAccessId->visit_members, true);

        $isMemberBlocked = BlockList::memberBlock($visit_members);

    

        $visit_status = ($isVisitorBlocked || $isMemberBlocked) ? 7 : 6;

        $currentDateTime = now();

        $controlAccessId->update([
            'date' => $currentDateTime->toDateString(),
            'time' => $currentDateTime->toTimeString(),
            'visit_status' => $visit_status,
            'personnel_id' => $validatedData['personnel_id']
        ]);
        if ($visit_status == 7) {
            return response()->json(['message' => 'The user or a member is blocked and the operation is denied.'], 403);
        }

        $entries = [];
        $entries[] = [
            'homeowner_id' => $controlAccessId->homeowner_id,
            'admin_id' => $controlAccessId->admin_id,
            'visitor_id' => $controlAccessId->visitor_id,
            'personnel_id' => $controlAccessId->personnel_id,
            'visit_members' => $controlAccessId->visit_members,
            'visit_date' => $currentDateTime->toDateString(),
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];
        Logbook::insert($entries);

        
        return response()->json(['scanned' => true], 200);
    }


    public function fetchAllRequestMobile($id){
        $fetchRequests = ControlAccess::with('visitor', 'homeowner')->fetchRequests($id);
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
