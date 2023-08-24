<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationRequest;
use Illuminate\Support\Facades\Redirect;

class VerificationRequests extends Controller
{
 

    public function mobileStore(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'family_member' => 'required|array',
            'block_no' => 'integer|required',
            'lot_no' => 'integer|required',
        ]);
        $user = User::findOrFail($validatedData['user_id']);
        $verificationRequest = VerificationRequest::create([
            'user_id' => $user->id,
            'family_member' => json_encode($request->json('family_member')),
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
