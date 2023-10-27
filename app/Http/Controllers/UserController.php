<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Http\Requests\AuthRequests\UserAuthStoreRequest;
use App\Http\Requests\UserRequests\UserUpdateProfileMobileRequest;
use App\Http\Requests\UserRequests\UserUpdateProfilePictureRequest;

class UserController extends Controller
{

    public function store(UserAuthStoreRequest $request){
        $validated = $request->validated();
    
        if (array_key_exists('family_member', $validated)) {
            $validated['family_member'] = json_encode($validated['family_member']);
        }
        
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_profile', 'public');
        }
        $validated['photo'] = $imagePath;
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
    
        $redirectRoute = $this->getRedirectRouteRegister($request);
    
        return redirect()->route($redirectRoute);      
    }
    

    public function getRedirectRouteRegister(Request $request): string
    {
        if ($request->has('form_type')) {
            $formType = $request->input('form_type');
            switch ($formType) {
                case 'registerVisitor':
                    return 'visitor';
                case 'registerHomeowner':
                    return 'homeowner';
                case 'registerPersonnel':
                    return 'personnel';
                case 'registerAdmin':
                    return 'admin';
                default:
                    return '/home';
            }
        }
    
        return '/home';
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

    public function updateProfilePicMobile(UserUpdateProfilePictureRequest $request, User $id)
    {
        $validated = $request->validated();
    
        // Check if 'photo' field exists in the request
        if ($request->hasAny('photo')) {
            
            // Store the image if 'photo' is present
            $imagePath = $request->file('photo')->store('user_profile', 'public');
            $validated['photo'] = $imagePath;
        }
    
        // Update the user's profile with the validated data
        $id->update($validated);
        
        return response()->json(['data' => $validated], 200);
    }
    
    
    

    public function updateMobile(UserUpdateProfileMobileRequest $request, User $id)
    {
        try {
            $validated = $request->validated();
    
    
            $id->update($validated);
    
    
            return response()->json(['data' => $validated], 200);
        } catch (\Exception $e) {
            // Log the error
    
            return response()->json(['error' => 'An error occurred'], 500);
        }
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

    public function getProfileMobile($id){

        $user = User::where('id' , $id)->first();
        return response()->json(['data' => $user], 200);
    }
    

}

