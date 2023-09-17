<?php

namespace App\Http\Controllers;

use App\Models\User;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AuthRequests\UserLoginRequest;
use App\Http\Requests\AuthRequests\UserAuthStoreRequest;


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


    public function login(UserLoginRequest $request)
    {
        $validated = $request->validated();
    
        $user = User::checksRoleWithUsername($validated['user_name'], 4);
    
        if ($user) {
            $credentials = $request->only('user_name', 'password');
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
    
                // Generate an API token using Sanctum
                $user->tokens()->delete(); // Delete existing tokens, if any
                $token = $user->createToken('web-token')->plainTextToken;
                
                return redirect('/home')->with(['token' => $token]);
            }
        }
    
        return back()->withErrors([
            'user_name' => 'Access denied. The provided credentials do not match our records.',
        ])->onlyInput('user_name');
    }
    
    public function logout(Request $request)
    {
        // Clear the user's authentication state
        Auth::logout();
        Session::flush();

        // Invalidate the session
        $request->session()->invalidate();
    
        // Regenerate the CSRF token
        $request->session()->regenerateToken();
    
        // Redirect the user to the home page
        return redirect('/')->with('success', 'You have been logged out successfully.');
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
        
        if (Auth::attempt($validated))
        {
           /** @var \App\Models\User $user **/
            $user = Auth::user();
            $token = $user->createToken('mobile')->plainTextToken; // Create a token for the user
    
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token, // Return the token
            ], 200);
        }
        else
        {
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
