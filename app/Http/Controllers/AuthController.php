<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'user_name' => ['required', 'min:6', Rule::unique('users', 'user_name')],
            'email' => ['required', 'min:4',   'email'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'], 
            'photo' => ['image', 'nullable'],
            'password' => ['required', 'min:6'],
            
        ]);
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;
        
        $validated['password'] = Hash::make($validated['password']);    
        User::create($validated);
        return redirect('/');
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'user_name' => 'required',
            'password' => 'required'
        ]);
    
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
}
