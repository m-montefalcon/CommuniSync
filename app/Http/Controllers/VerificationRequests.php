<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationRequest;
use Illuminate\Support\Facades\Redirect;

class VerificationRequests extends Controller
{
    public function showRequests(){
        $verifyRequests = VerificationRequest::all();
        return view('content.verificationRequest', compact('verifyRequests'));
    }

    public function mobileStore(Request $request){
       // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'family_member' => 'required',
            'house_no' => 'required',
            'manual_visit_option' => 'required'
        ]);
  // Retrieve the user by ID
        $user = User::findOrFail($validatedData['user_id']);

        // Create a new verification request
        $verificationRequest = ([
            'user_id' => $user->id,
            'family_member' => $validatedData['family_member'],
            'house_no' => $validatedData['house_no'],
            'user_name' => $user->user_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'contact_number' => $user->contact_number,
            'email' => $user->email,
            'photo' => $user->photo,
            'manual_visit_option' => $validatedData['manual_visit_option'],
            

        ]);
        // Create a new verification request
        $verificationRequest = VerificationRequest::create($verificationRequest);

        // Update the user's role to 2 (homeowner)
        // $user = User::findOrFail($verificationRequest->user_id);
        // $user->role = 2;
        // $user->family_member = $verificationRequest->family_member;
        // $user->house_no = $verificationRequest->house_no;
        // $user->save();
        // return response()->json(['message' => 'Verification request submitted successfully']);
    }


    public function update(Request $request,  $id)
    {
        $verificationRequest = VerificationRequest::findOrFail($id);
    
        // Find the user based on the user_id
        $user = User::findOrFail($verificationRequest->user_id);

        // Update the user's fields
        $user->house_no = $verificationRequest->house_no;
        $user->family_member = $verificationRequest->family_member;
        $user->email_verified_at = now(); // Set the email_verified_at field to the current timestamp
        $user->manual_visit_option = $verificationRequest->manual_visit_option;
        $user->role = 2; // Set the role to 2

        // Save the changes to the user model
        $user->save();
        $verificationRequest->delete();


        return redirect()->route('verificationRequests');
    }
    

}
