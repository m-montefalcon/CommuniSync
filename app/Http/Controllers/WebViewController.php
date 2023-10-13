<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Facades\DB;
use App\Models\VerificationRequest;
use App\Http\Controllers\Controller;
use App\Models\Logbook;

class WebViewController extends Controller
{
    //USER ROUTES
    public function returnLandingPageView(){
        return view('user.landingPage');

    }
    public function returnLoginWebView(){
        return view('user.login');
    }

    public function returnRegisterVisitorView(){
        return view('user.registerVisitor');
    }

    public function returnRegisterHomeownerView(){
        return view('user.registerHomeowner');
    }

    public function returnRegisterPersonnelView(){
        return view('user.registerPersonnel');
    }

    public function returnRegisterAdminView(){
        return view('user.registerAdmin');
    }


    //CONTENTS ROUTES
    public function returnHomeView(){

        return view('content.home');
    }

    public function returnProfileView(){
        return view('content.profile');
    }

    public function showVisitor(){
        $visitors = User::checksRole(1);
        return view('content.visitor', compact('visitors'));
        
    }
    public function showHomeowner(){
        $homeowners = User::checksRole(2);
        return view('content.homeowner', compact('homeowners'));
    }
    public function showPersonnel(){
        $personnels = User::checksRole(3);
        return view('content.personnel', compact('personnels'));
    }
    public function showAdmin(){
        $admins = User::checksRole(4);
        return view('content.admin', compact('admins'));
    }

    public function showVisitorId($id){
        $visitor = User::findorFail($id);
    
        return view('credentialsForm.editVisitorForm', compact('visitor'));
       
    }

    public function showHomeownerId($id){
        $homeowner = User::findorFail($id);
        $homeowner->family_member = json_decode($homeowner->family_member, true);

        return view('credentialsForm.editHomeownerForm', compact('homeowner'));
    }

    public function showPersonnelId($id){
        $personnel = User::findorFail($id);
    
        return view('credentialsForm.editPersonnelForm', compact('personnel'));
    }
    public function showAdminId($id){
        $admin = User::findorFail($id);
    
        return view('credentialsForm.editAdminForm', compact('admin'));
    }
    public function showRequests()
    {
        $verifyRequests = VerificationRequest::with('user')->get();
        return view('verification.verificationRequest', compact('verifyRequests'));
    }

    public function show(){
        $announcements = Announcement::with('admin')->get();
        return view('announcement.announcement', compact('announcements'));
    }

    public function showCreateForm(){
        return view('announcement.announcementForm');
    }
    public function test(){
        $qrcodes  = ControlAccess::all('qr_code');

        return view('qrcode', compact('qrcodes'));
    }
    public function announcementFetchId($id){
        // $fetchRequests = Announcement::findOrFail($id)->get();
        $announcement = Announcement::findOrFail($id);
        return view('announcement.viewAnnouncement', compact('announcement'));

    }
    public function getAllCAF(){
        $fetchRequests = ControlAccess::with('visitor', 'homeowner')
        ->where('visit_status', '2')
        ->get();
        
        return view('accessControl.accessControl', compact('fetchRequests'));

    }

    public function fetch(){
        // $fetchALlComplaints =  Complaint::with('homeowner')->with('admin')->where('complaint_status', 1)->orWhere('complaint_status', 2)->get();
        $fetchALlComplaints = Complaint::status(1, 2)->with('homeowner', 'admin')->get();
        foreach ($fetchALlComplaints as $complaint) {
            $complaint->complaint_updates = json_decode($complaint->complaint_updates);
        }
        // @dd($fetchALlComplaints);
       return view('complaints.complaints', compact('fetchALlComplaints'));
    }
    public function fetchComplaintsHistory(){
        // $fetchALlComplaints =  Complaint::with('homeowner')->with('admin')->where('complaint_status', 1)->orWhere('complaint_status', 2)->get();
        $fetchALlComplaints = Complaint::where('complaint_status', 3)->get();
       return view('complaints.complaintsHistory', compact('fetchALlComplaints'));
    }
    
    public function getLb(){
        $fetchAllLb = Logbook::with('homeowner', 'admin', 'visitor', 'personnel')->get();
        return view('logbook', compact('fetchAllLb'));
    }

    public function fetchAllUserPayment(){
        $homeowners = User::checksRole(2);
        return view('tba', compact('homeowners'));
    }
}
