<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function update(Request $request, User $id)
    {
        $validated = $request->validate([
            'user_name' => ['required', 'min:6', Rule::unique('users', 'user_name')->ignore($id)],
            'email' => ['required', 'min:4', 'email'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],
            'manual_visit_option' => ['sometimes', 'in:0,1'],
            'house_no' => ['nullable', 'required_with:family_member'],
            'family_member' => ['nullable', 'required_with:house_no'],
            'password' => ['sometimes', 'required', 'min:6'],
        ]);
    
        if ($request->has('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }
    
        $id->update($validated);
    
        $redirectRoute = $this->getRedirectRoute($request);

        return redirect()->route($redirectRoute);
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

