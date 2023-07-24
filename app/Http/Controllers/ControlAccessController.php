<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class ControlAccessController extends Controller
{
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
}
