<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\ValidatedData;

class PaymentRecordController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'homeowner_id' => 'required',
            'transaction_number' => 'required',
            'notes' => 'nullable',
            'payment_amount' => 'required',
        ]);
        $validatedData['payment_date'] = now()->toDateString();
        $validatedData['admin_id'] = Auth::id();
        PaymentRecord::create($validatedData);
        return response()->json(['payment method'=> true, $validatedData, 200]);
    }

    public function getALl()
    {
        $fetchALlRecords = PaymentRecord::all();
        return response()->json([$fetchALlRecords, 200]);

    }

    public function getId($id)
    {
        $fetchRequests = PaymentRecord::with('homeowner')->findOrFail($id);
        return response()->json([$fetchRequests, 200]);
    }
    
}
