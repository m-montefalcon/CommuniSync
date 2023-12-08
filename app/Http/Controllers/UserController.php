<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
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
                    break;
                case 'registerHomeowner':
                    return 'homeowner';
                    break;
                case 'registerPersonnel':
                    return 'personnel';
                    break;
                case 'registerAdmin':
                    return 'admin';
                    break;
                default:
                    return '/home';
                    break;
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
    
        // $redirectRoute = $this->getRedirectRoute($request);

        return redirect()->back();
    }


    
    public function updateProfilePicMobile(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|max:' . (env('UPLOAD_MAX_SIZE', 30) * 1024), // Convert MB to KB
        ]);
        
    
        $userId = User::findOrFail($id);
    
        if ($request->hasFile('photo')) {
            // Delete the existing profile picture
            if ($userId->photo) {
                Storage::disk('public')->delete($userId->photo);
            }
    
            $photoFile = $request->file('photo');
            $imagePath = $photoFile->store('user_profile', 'public');
            $validated['photo'] = $imagePath;
            $userId->update($validated);
            return response()->json(['data' => $validated], 200);
        } else {
            return response()->json(['error' => 'Photo is required'], 400);
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|string|same:new_password',
        ]);
        /** @var \App\Models\User $user **/

        $user = Auth::user();

        try {
            // Update the password directly
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);

            return redirect()->route('profile')->with('success', 'Password changed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('profile')->withErrors(['error' => 'An error occurred while changing the password.']);
        }
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

    // public function getRedirectRoute(Request $request): string
    // {
    //     if ($request->has('form_type')) {
    //         $formType = $request->input('form_type');
    //         switch ($formType) {
    //             case 'editVisitorForm':
    //                 return '/visitor';
    //                 break;
    //             case 'editHomeownerForm':
    //                 return 'homeowner';
    //                 break;
    //             case 'editPersonnelForm':
    //                 return 'personnel';
    //                 break;
    //             case 'editAdminForm':
    //                 return 'admin';
    //                 break;
    //             default:
    //                 return '/home';
    //                 break;
    //         }
    //     }
    
    //     return '/home';
    // }

    public function getProfileMobile($id){

        $user = User::where('id' , $id)->first();
        return response()->json(['data' => $user], 200);
    }
    

}

