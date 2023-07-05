<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebViewController extends Controller
{
    public function ReturnLoginWebView(){
        return view('/login');
    }

    public function ReturnRegisterView(){
        return view('/register');
    }
}
