<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRequests\UserAuthStoreRequest;
use App\Http\Requests\AuthRequests\UserLoginRequest;

class AuthController extends Controller
{
    public function store(UserAuthStoreRequest $request){
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;
        
        $validated['password'] = Hash::make($validated['password']);    
        User::create($validated);
        return redirect('/');
        // return response()->json([
        //     'message' => 'User registered successfully'// Pass the user data to the response
        // ]);    
    }

    public function login(UserLoginRequest $request) {
        $validated = $request->validated();
    
        $user = User::where('user_name', $validated['user_name'])->first();
    
        if ($user && $user->role == 4) {
            $credentials = $request->only('user_name', 'password');
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
    
                return redirect('/home');
                
            }
        }
    
        return back()->withErrors([
            'user_name' => 'Access denied. The provided credentials do not match our records.',
        ])->onlyInput('user_name');
    }
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

//-----------------------------------------MOBILE----------------------------------------//
    public function mobileStore(UserAuthStoreRequest $request)
    {
        $validated = $request->validated();
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 1;
        $user = User::create($validated);
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
             200// Pass the user data to the response
        ]);    
    }

    public function loginMobile(UserLoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt( $validated)) {
            // Authentication successful
            $user = Auth::user(); // Retrieve the authenticated user
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                 200 // Pass the user data to the response
            ]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logoutMobile(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    
    
}
