<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Http\Requests\AuthRequests\UserAuthStoreRequest;

class UserController extends Controller
{

    public function store(UserAuthStoreRequest $request){
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['remember_token'] = Str::random(60);    
        User::create($validated);
        return redirect('/');
      
    }
    
    public function update(UserUpdateRequest $request, User $id)
    {
        $validated = $request->validated();
    
        if ($request->has('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }
    
        $id->update($validated);
    
        $redirectRoute = $this->getRedirectRoute($request);

        return redirect()->route($redirectRoute);
    }
    

    // public function destroy(Request $request, User $id){
    //     $id -> delete();
    //     return redirect('/visitor');
    // }

    public function getRedirectRoute(Request $request): string
    {
        if ($request->has('form_type')) {
            $formType = $request->input('form_type');
            switch ($formType) {
                case 'editVisitorForm':
                    return 'visitor';
                case 'editHomeownerForm':
                    return 'homeowner';
                case 'editPersonnelForm':
                    return 'personnel';
                case 'editAdminForm':
                    return 'admin';
                default:
                    return '/home';
            }
        }
    
        return '/home';
    }
    

}

