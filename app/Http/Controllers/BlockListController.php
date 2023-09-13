<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlockLists\UserRequestBlockListRequest;
use App\Http\Requests\BlockLists\UserValidatedBlockListRequest;
use App\Models\BlockList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LDAP\Result;

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
        $id->fill($validatedData);
        $id->blocked_date = Carbon::now()->toDateString();
        $id->save();
        return response()->json(['validated success' => true], 200);
    }
}
