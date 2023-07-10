<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationRequests extends Controller
{
    public function showRequests(){
        return view('content.verificationRequest');
    }
}
