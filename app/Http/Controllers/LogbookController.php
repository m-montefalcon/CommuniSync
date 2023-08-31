<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class LogbookController extends Controller
{
    public function get(Request $request){
        $validatedData = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
        ]);
        $findHomeowner = User::where('first_name', $validatedData['first_name'])
                                ->where('last_name', $validatedData['last_name'])
                                ->where('role', 2)
                                ->where('manual_visit_option', 1)
                                ->get();


       

        if(!$findHomeowner){
            return response()->json(['message' => 'The user does not exist'], 403);

        }

        // $isMvoOn = $findHomeowner->manual_visit_option;
    
        // @dd( $isMvoOn );
        
        return response()->json(['message' => 'Info', $findHomeowner , 200]);

    }
}
