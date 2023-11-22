<?php

namespace App\Http\Controllers;

use LDAP\Result;
use Carbon\Carbon;
use App\Models\BlockList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BlockLists\UserRequestBlockListRequest;
use App\Http\Requests\BlockLists\UserValidatedBlockListRequest;

class BlockListController extends Controller
{
    public function request(UserRequestBlockListRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['blocked_date']   = Carbon::now()->toDateString();
        $validatedData['blocked_status'] = "1";
        BlockList::create($validatedData);
        return response()->json(['request success' => true], 200);
    }
    

    public function validated(UserValidatedBlockListRequest $request, BlockList $id)
    {
        $validatedData = $request->validated();
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "2";
        $id->update($validatedData);
        return redirect()->back();
    }
    public function denied(UserValidatedBlockListRequest $request, BlockList $id)
    {
        $validatedData = $request->validated();
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "3";
        $id->update($validatedData);
        return redirect()->back();
    }
    public function remove(BlockList $id){
        $id->blocked_date = Carbon::now()->toDateString();
        $adminId = Auth::id();
        $validatedData['admin_id'] = $adminId;
        $validatedData['blocked_status'] = "3";
        $id->update($validatedData);
        return redirect()->back();

    }
}
