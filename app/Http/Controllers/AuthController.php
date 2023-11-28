<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AuthRequests\UserLoginRequest;
use App\Http\Requests\AuthRequests\UserAuthStoreRequest;




class AuthController extends Controller
{

    public function adminStore(UserAuthStoreRequest $request){
        $validated = $request->validated();
    
        // Validate the PIN
        $enteredPIN = $request->input('pin');
        $predefinedPIN = config('app.predefined_pin');
    
        if ($enteredPIN !== $predefinedPIN) {
            return redirect()->back()->withErrors(['pin' => 'Incorrect PIN code. Please try again.']);
        }
    
        // PIN is correct, continue with user registration
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;
    
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 4;
    
        // Add the following line to store the FCM token
        $validated['fcm_token'] = $request->input('fcm_token');
    
        $user = User::create($validated);
    
        return view('user.landingPage');
    }
    
    
    public function login(UserLoginRequest $request)
    {
        $validated = $request->validated();
    
        $user = User::checksRoleWithUsername($validated['user_name'], 4)->first();
    
        if ($user) {
            $credentials = $request->only('user_name', 'password');
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
    
                    /** @var \App\Models\User $user **/
                    $user = Auth::user();
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
        // Revoke the web token
        $request->user()->tokens->where('name', 'web-token')->each(function ($token, $key) {
            $token->delete();
        });
    
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

    // Add the following line to store the FCM token
    $validated['fcm_token'] = $request->input('fcm_token');

    $user = User::create($validated);

    return response()->json([
        'message' => 'User registered successfully',
    ], 200);
}

public function loginMobile(UserLoginRequest $request)
{
    $validated = $request->validated();
    
    if (Auth::attempt($validated))
    {
       /** @var \App\Models\User $user **/
        $user = Auth::user();
        $token = $user->createToken('mobile-token')->plainTextToken; // Create a token for the user
        $fcmToken = $user->fcm_token; // Get the FCM token from the user

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'fcm_token' => $fcmToken, // Include the FCM token in the response
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
        // Get the authenticated user
        /** @var \App\Models\User $user **/
        $user = Auth::user();
 
        // Get the specific token ID based on the authentication method (mobile)
        $tokenId = $user->currentAccessToken()->id;
 
        // Revoke the specific token
        $user->tokens()->where('id', $tokenId)->delete();
 
        // Clear the user's authentication state
        $request->user()->currentAccessToken()->delete();
 
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    
    
}
