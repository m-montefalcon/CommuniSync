<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Facades\DB;
use App\Models\VerificationRequest;
use App\Http\Controllers\Controller;


class WebViewController extends Controller
{
    //USER ROUTES
    public function returnLandingPageView(){
        return view('user.landingPage');

    }
    public function returnLoginWebView(){
        return view('user.login');
    }

    public function returnRegisterView(){
        return view('user.register');
    }


    //CONTENTS ROUTES
    public function returnHomeView(){

        return view('content.home');
    }

    public function returnProfileView(){
        return view('content.profile');
    }

    public function showVisitor(){
        $visitors = User::where('role', 1)->get();
        return view('content.visitor', compact('visitors'));
        
    }
    public function showHomeowner(){
        $homeowners = User::where('role', 2)->get();
        return view('content.homeowner', compact('homeowners'));
    }
    public function showPersonnel(){
        $personnels = User::where('role', 3)->get();
        return view('content.personnel', compact('personnels'));
    }
    public function showAdmin(){
        $admins = User::where('role', 4)->get();
        return view('content.admin', compact('admins'));
    }

    public function showVisitorId($id){
        $visitor = User::findorFail($id);
    
        return view('credentialsForm.editVisitorForm', compact('visitor'));
       
    }


    public function showHomeownerId($id){
        $homeowner = User::findorFail($id);
    
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
        $announcements = Announcement::all();
        return view('announcement.announcement', compact('announcements'));
    }

    public function showCreateForm(){
        return view('announcement.announcementForm');
    }
    public function test(){
        $qrcodes  = ControlAccess::all('qr_code');

        return view('qrcode', compact('qrcodes'));
    }

}
