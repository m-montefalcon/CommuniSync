<?php

namespace App\Http\Controllers;

use App\Models\BlockList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LDAP\Result;

class BlockListController extends Controller
{
    public function request(Request $request)
    {
        $validatedData = $request->validate([
            'homeowner_id'     => ['required', 'numeric'],
            'first_name'       => ['required'],
            'last_name'        => ['required'],
            'blocked_reason'   => ['required'],
        ]);
        $validatedData['blocked_date']   = Carbon::now()->toDateString();
        $validatedData['blocked_status'] = "1";
        BlockList::create($validatedData);
        return response()->json(['request success' => true], 200);
    }
    

    public function validated(Request $request, BlockList $id)
    {
        $validatedData = $request->validate([
            'admin_id' => ['required', 'numeric'],
            'blocked_status_response_description'=> ['nullable'],
        ]);
        $id->fill($validatedData);
        $id->blocked_date = Carbon::now()->toDateString();
        $id->save();
        return response()->json(['validated success' => true], 200);
    }
}
