<?php

namespace App\Http\Controllers;

use LDAP\Result;
use Carbon\Carbon;
use App\Models\BlockList;
use Illuminate\Http\Request;
use App\Events\NewNotificationEvent;
use Illuminate\Support\Facades\Auth;
use App\Console\Commands\NotificationService;
use App\Http\Requests\BlockLists\UserRequestBlockListRequest;
use App\Http\Requests\BlockLists\UserValidatedBlockListRequest;

class BlockListController extends Controller
{  
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function request(UserRequestBlockListRequest $request, NotificationsController $notificationController)
    {
        $validatedData = $request->validated();
        $validatedData['blocked_date']   = Carbon::now()->toDateString();
        $validatedData['blocked_status'] = "1";
        BlockList::create($validatedData);
        $notification = $notificationController->createNotificationByRoles('New blocklist request', 'New blockedlist request has recieved, check it Blocked List Tab.', 4);
        broadcast(new NewNotificationEvent($notification))->toOthers();
        return response()->json(['request success' => true], 200);
    }
    

    public function validated(UserValidatedBlockListRequest $request, BlockList $id, NotificationsController $notificationController)
    {
        $validatedData = $request->validated();
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "2";
        $id->update($validatedData);
        $blocked_name = $id->first_name . ' ' . $id->last_name;
        $body = "Your request to restrict " . $blocked_name . " to enter the subdivision has approved";
        $this->notificationService->sendNotificationById($id->homeowner_id, 'Blocked list', 'Your request to restrict ' . $blocked_name . ' to enter the subdivision has been approved.');
        $notificationController->createNotificationById('Blocked list', $body, $id->homeowner_id);

        return redirect()->back();
    }
    public function denied(UserValidatedBlockListRequest $request, BlockList $id, NotificationsController $notificationController)
    {
        $validatedData = $request->validated();
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "3";
        $id->update($validatedData);
        $blocked_name = $id->first_name . ' ' . $id->last_name;
        $body = "Reason for disapproval : " . $id->blocked_status_response_description;
        $this->notificationService->sendNotificationById($id->homeowner_id, 'Your request to restrict ' . $blocked_name . ' to enter the subdivision has denied', $body);
        $notificationController->createNotificationById('Your request to restrict ' . $blocked_name . '  to enter the subdivision has denied', $body, $id->homeowner_id);
       
        return redirect()->back();
    }
    public function remove(BlockList $id){
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "3";
        $id->update($validatedData);
        return redirect()->back();

    }
}
