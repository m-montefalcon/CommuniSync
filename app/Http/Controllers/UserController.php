<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function update(Request $request, User $id)
    {
        $validated = $request->validate([
            'user_name' => ['required', 'min:6', Rule::unique('users', 'user_name')->ignore($id)],
            'email' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],
            'manual_visit_option' => ['nullable'],
            'block_no' => 'required',
            'lot_no' => 'required',
            'family_member' => ['nullable'],
            'password' => ['sometimes', 'required', 'min:6'],
        ]);
    
        if ($request->has('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }
    
        $id->update($validated);
    
        // $redirectRoute = $this->getRedirectRoute($request);
        
        return response()->json($id, 200);
    }
    

    public function destroy(Request $request, User $id){
        $id -> delete();
        return redirect('/visitor');
    }

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

