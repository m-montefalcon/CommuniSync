<?php

namespace App\Http\Controllers;

use App\Models\ControlAccess;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;


class ControlAccessController extends Controller
{
    //SEARCH THE HOMEOWNER ONLY
    public function search(Request $request)
    {
        try {
            $username = $request->input('username');
            $users = User::where('user_name', 'LIKE', "%{$username}%")
                         ->where('role', 2)
                         ->get();

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error'], 500);
        }
    }


    //REQUEST ACCESS VISITOR ONLY
    public function request(Request $request){
       
        $validatedData = $request->validate([
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'destination_person' => ['required'],
            'visit_members' => ['nullable', 'array'],
        ]);
    
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $validatedData['visit_members'] = json_encode($validatedData['visit_members']);
    
        ControlAccess::create($validatedData);
    
        return response()->json(['success' => true]);
       
    }


}
