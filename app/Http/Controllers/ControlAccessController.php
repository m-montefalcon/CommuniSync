<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use App\Events\NewCAFEvent;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\NewNotificationEvent;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Console\Commands\NotificationService;
use Illuminate\Session\TokenMismatchException;
use App\Http\Requests\ControlAccess\SpCheckIdRequest;
use App\Http\Requests\ControlAccess\UserAccessRequest;
use App\Http\Requests\ControlAccess\UserRecordControlAccessRequest;
use App\Http\Requests\ControlAccess\UserRequestControllAccessRequest;


class ControlAccessController extends Controller
{
    protected $notificationModel;
    protected $notificationService;

    public function __construct(Notification $notificationModel, NotificationService $notificationService)
    {
        $this->notificationModel = $notificationModel;
        $this->notificationService = $notificationService;
    }
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
    public function requestMobile(UserRequestControllAccessRequest $request,  NotificationsController $notificationController) 
    {
        $validatedData = $request->validated();
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $controlAccess = ControlAccess::create($validatedData);

        $visitorId =  User::findOrFail($validatedData['visitor_id']);
        $title = 'Request Access';
        $body = "{$visitorId->first_name} {$visitorId->last_name} sent you a request for visit access.";
        $hmId= $validatedData['homeowner_id'];

        $this->notificationService->sendNotificationById($hmId, $title, $body);
        $notificationController->createNotificationById($body, 'You may check the details under Home page', $hmId);

        return response()->json(['request success' => true, 'data' => $controlAccess], 200);
    }

    //HOMEOWNER ACCEPT TO VISITOR
    public function acceptMobile(UserAccessRequest $request, NotificationsController $notificationController) 
    {
        $validatedData = $request->validated();
        $id = ControlAccess::findOrFail($validatedData['id']);
        $validatedData['visit_status'] = 2;
        $validatedData['date'] = now()->toDateString();
        $validatedData['time'] = now()->toTimeString();
        $id->update($validatedData);
    
        // Fetch updated notifications after accepting the request
        $notifications = $notificationController->fetchNotificationByRoles(); // Assuming you have a method to fetch notifications
    
        // Broadcast with UI
        broadcast(new NewCAFEvent($validatedData))->toOthers();
    
        // Create and broadcast the new notification
        $notification = $notificationController->createNotificationByRoles('New Accepted Control Access Request', 'New Control Access has received, check it under Control Access Tab.', 4);
        broadcast(new NewNotificationEvent($notification))->toOthers();
    
        // Include the updated notifications in the response
        return response()->json(['accepted' => true, 'id' => $id, 'notifications' => $notifications], 200);
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
    public function validated(ControlAccess $id, NotificationsController $notificationController)
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

        $admin =  User::findOrFail($id->admin_id);
        $title = 'Your QR code is ready!';
        $body = "{$admin->first_name} {$admin->last_name} validated your request access. You may check your qr code";
        $this->notificationService->sendNotificationById($id->visitor_id, $title, $body);
        $notificationController->createNotificationById($body, 'You may check the details under dashboard', $id->visitor_id);

        return redirect()->back();
    }

    public function rejected($id, NotificationsController $notificationController){
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
        $admin =  User::findOrFail($Rejectedid->admin_id);
        $visitor =  User::findOrFail($Rejectedid->visitor_id);
        $title = 'Rejected Request';
        $visitorName = "{$visitor->first_name} {$visitor->last_name}";
        $body = "{$admin->first_name} {$admin->last_name} rejected the visit access for {$visitorName}. If this is some mistake, try again or file a complaint";
        $this->notificationService->sendNotificationById($Rejectedid->homeowner_id, $title, $body);
        $this->notificationService->sendNotificationById($Rejectedid->visitor_id, $title, $body);
        $notificationController->createNotificationById('Rejected Request',$body, $Rejectedid->homeowner_id);
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

    public function recordedMobile(UserRecordControlAccessRequest $request, NotificationsController $notificationController){
        $validatedData = $request->validated();
        
        // Use find instead of findOrFail to avoid throwing an exception
        $controlAccessId = ControlAccess::find($validatedData['id']);
        $visitor = User::find($controlAccessId->visitor_id);


        // Check if the controlAccessId and visitor exist
        if (!$controlAccessId || !$visitor) {
            return response()->json(['message' => 'User or Control Access not found'], 404);
        }
        $today = now()->toDateString();

        // Check if the date is today
        if ($controlAccessId->date != $today) {
            return response()->json(['message' => 'QR code has expired.'], 403);
        }
    
        $isVisitorBlocked = BlockList::visitorBlocked($visitor)->exists();
        $visit_members = json_decode($controlAccessId->visit_members, true);
        $isMemberBlocked = BlockList::memberBlock($visit_members);
    
        $visit_status = ($isVisitorBlocked || $isMemberBlocked) ? 7 : 6;
    
        $currentDateTime = now();
    
        // Update the controlAccessId directly without using the update method
        $controlAccessId->date = $currentDateTime->toDateString();
        $controlAccessId->time = $currentDateTime->toTimeString();
        $controlAccessId->visit_status = $visit_status;
        $controlAccessId->personnel_id = $validatedData['personnel_id'];
        $controlAccessId->save();
    
        if ($visit_status == 7) {
            return response()->json(['message' => 'The user or a member is blocked and the operation is denied.'], 403);
        }
    
        // Create a new Logbook entry directly without using an array
        Logbook::create([
            'homeowner_id' => $controlAccessId->homeowner_id,
            'admin_id' => $controlAccessId->admin_id,
            'visitor_id' => $controlAccessId->visitor_id,
            'personnel_id' => $controlAccessId->personnel_id,
            'visit_members' => $controlAccessId->visit_members,
            'contact_number' => $visitor->contact_number,
            'logbook_status' => 1,
            'destination_person' => $controlAccessId->destination_person,
            'visit_date_in' => $currentDateTime->toDateString(),
            'visit_time_in' => $currentDateTime->toTimeString(),
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);
        $visitMembers = json_decode($controlAccessId->visit_members, true);

        if (is_array($visitMembers)) {
            $namesString = implode(', ', $visitMembers);
        } else {
            // Handle the case where $visitMembers is not an array or is null
            $namesString = $controlAccessId->visit_members; // Assign the original value
        }        
        $visitorName = $visitor->first_name . ' ' . $visitor->last_name . ', ';

        $id = $controlAccessId->homeowner_id;
        $title = 'Control Access';
        $body = "Visitors : " . $visitorName .  $namesString . "  was qr scanned and verified. They are on their way!";
    
        $this->notificationService->sendNotificationById($controlAccessId->homeowner_id, $title, $body);
        $notificationController->createNotificationById($title, $body, $controlAccessId->homeowner_id);

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
