<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function show(){
        return view('announcement.announcement');
    }


    public function announcementStore(Request $request){
        dd($request->all());
    }
}
