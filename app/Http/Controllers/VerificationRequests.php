<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\VerificationRequest\UserVerificationRequest;

class VerificationRequests extends Controller
{

    public function mobileCheckExist($id){
        $alreadyVerified = User::where('id', $id)->where('role', "2")->exists();
        if ($alreadyVerified) {
            return response()->json(["message" => "You are already approved. You may logout and sign in again."], 410);
        }
    
        $existing = VerificationRequest::ifExist($id);
        if ($existing) {
            return response()->json(["message" => "You already have a pending request. Please wait for the confirmation."],403);
        } else {
            return response()->json(["message" => "SUCCESS"], 200);
        }
    }
    

    public function mobileStore(UserVerificationRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::findOrFail($validatedData['user_id']);
        $verificationRequest = VerificationRequest::create([
            'user_id' => $user->id,
            'family_member' => json_encode($validatedData['family_member']),
            'block_no' => $validatedData['block_no'],
            'lot_no' => $validatedData['lot_no'],
        ]);
        return response()->json($verificationRequest, 200);
    }


    public function update(VerificationRequest $id){
        $user = User::findOrFail($id->user_id);
        $user->update([
            'lot_no' => $id->lot_no,
            'block_no' => $id->block_no,
            'family_member' => $id->family_member,
            'manual_visit_option' => 0,
            'role' => 2,
        ]);
        $id->delete();
        return redirect()->route('verificationRequests');
        

    }
    

}
