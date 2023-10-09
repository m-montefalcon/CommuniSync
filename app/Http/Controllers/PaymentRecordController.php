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
        $fetchRecords = PaymentRecord::where('homeowner_id', $id)->get();
        $fetchAllAmount = PaymentRecord::where('homeowner_id', $id)->pluck('payment_amount');
        $totalAmount = $fetchAllAmount->sum();
        $result = $totalAmount / 200;
    
        $currentMonth = date('n'); // Current month in numeric format (1-12)
        $currentYear = date('Y'); // Current year
        $paymentMonth = $result % 12 ? $result % 12 : 12;
        $paymentYear = $currentYear + floor($result / 12);
    
        if($paymentMonth > $currentMonth){
            $message = "You are ahead by " . ($paymentMonth - $currentMonth) . " months. Last payment is in " . date("F", mktime(0, 0, 0, $paymentMonth, 10)) . " " . $paymentYear . ".";
        } elseif($paymentMonth < $currentMonth){
            $message = "You are behind by " . ($currentMonth - $paymentMonth) . " months. Last payment is in " . date("F", mktime(0, 0, 0, $paymentMonth, 10)) . " " . $paymentYear . ".";
        } else {
            $message = "You are up to date. Last payment is in " . date("F", mktime(0, 0, 0, $paymentMonth, 10)) . " " . $paymentYear . ".";
        }
    
        return response()->json(['records'=>$fetchRecords, 'message'=>$message,  'total amount'=>$totalAmount,  200]);
    }
    
    
    
    
    
}
