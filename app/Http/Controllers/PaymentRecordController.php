<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\ValidatedData;
use App\Http\Requests\PaymentRecords\UserPaymentRequest;

class PaymentRecordController extends Controller
{
    public function store(UserPaymentRequest $request)
    {
        $validatedData = $request->validated();
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
    public function getStatus($id){
        $fetchRecords = PaymentRecord::with('admin')->where('homeowner_id', $id)->get();
        $fetchAllAmount = PaymentRecord::where('homeowner_id', $id)->pluck('payment_amount');
        $totalAmount = $fetchAllAmount->sum();
        $monthsToAdd = floor($totalAmount / 200); // Round down to the nearest whole number of months to add
    
        $currentMonth = date('n'); // Current month in numeric format (1-12)
        $currentYear = date('Y'); // Current year
        $startMonth = 0; // Start from January 2023
        $startYear = 2023; // Start from January 2023
    
        $diffYears = $startYear - $currentYear;
        $diffMonths = $startMonth - $currentMonth + ($diffYears * 12);
    
        // Calculate months ahead or behind
        $monthsDifference = $diffMonths + $monthsToAdd;
    
        if ($monthsDifference > 0) {
            $message = "You are ahead by $monthsDifference months. Next payment is in " . date("F Y", strtotime("+ $monthsDifference months"));
        } elseif ($monthsDifference < 0) {
            $monthsDifference = abs($monthsDifference);
            $message = "You are behind by $monthsDifference months. Next payment is for " . date("F Y", strtotime("- $monthsDifference months"));
        } else {
            $message = "You are up to date. Last payment covered for " . date("F Y");
        }
    
        return response()->json(['records' => $fetchRecords, 'message' => $message], 200);
    }
    
    
    
    
    
    
}
