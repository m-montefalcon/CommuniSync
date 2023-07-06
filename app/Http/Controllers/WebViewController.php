<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

}
