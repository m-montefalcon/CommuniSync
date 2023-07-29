<?php

namespace App\Http\Controllers;

use App\Models\BlockList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LDAP\Result;

class BlockListController extends Controller
{
    public function request(Request $request){
        $validatedData = $request->validate([
                'homeowner_id' => ['required', 'integer'],
                'user_name' => ['nullable'],
                'first_name' => ['required'],
                'last_name' => ['required'],
                'contact_number' => ['nullable'],
                'block_reason'=> ['required']
            ]);

        $validatedData['blocked_date'] = Carbon::now()->toDateString();
        $validatedData['block_status'] = "1";
        BlockList::create($validatedData);

        return response()->json(['request success' => true], 200);

    }


    public function validated(Request $request, BlockList $id){
        $validatedData = $request->validate([
            'admin_id' => ['required', 'integer'],
            'block_status' => ['required'],
            'block_status_response_description' => ['nullable']
        ]);
        $validatedData['blocked_date'] = Carbon::now()->toDateString();
        
        $id->update($validatedData);
        return response()->json(['validated success' => true], 200);
    }
}
