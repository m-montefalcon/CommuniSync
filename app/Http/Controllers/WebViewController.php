<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebViewController extends Controller
{
    public function returnLandingPageView(){
        return view('user.landingPage');

    }
    public function returnLoginWebView(){
        return view('user.login');
    }

    public function returnRegisterView(){
        return view('user.register');
    }

    public function returnHomeView(){
        return view('content.home');
    }

}
