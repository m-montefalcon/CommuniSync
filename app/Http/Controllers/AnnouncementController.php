<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function create(){
        return view('announcement.createAnnouncementForm');
    }
}
