<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentRecordService;
use App\Console\Commands\NotificationService;
use Illuminate\Contracts\Support\ValidatedData;
use App\Http\Requests\PaymentRecords\UserPaymentRequest;


class PaymentRecordController extends Controller
{  
    protected $notificationService;
   
    private $pdfGenerationService;

    public function __construct(NotificationService $notificationService, PaymentRecordService $pdfGenerationService)
    {
        $this->notificationService = $notificationService;
        $this->pdfGenerationService = $pdfGenerationService;
    }
    public function store(UserPaymentRequest $request, NotificationsController $notificationController)
    {
        $validatedData = $request->validated();
        $validatedData['payment_date'] = now()->toDateString();
        $validatedData['admin_id'] = Auth::id();
        PaymentRecord::create($validatedData);
        $title = 'Monthly Due Payment Received';
        $body = 'A monthly due payment was received, amounting PHP ' . $validatedData['payment_amount'] . '. You may check it on Payment Records.';
        $id = $validatedData['homeowner_id'];
        
        $this->notificationService->sendNotificationById($id, $title, $body);
        $notificationController->createNotificationById($title, $body, $id);

        return redirect()->back();
    }


    public function getId($id)
    {
        $fetchRequests = PaymentRecord::with('homeowner')->findOrFail($id);
        return response()->json([$fetchRequests, 200]);
    }
    public function getStatus($id){
        $fetchRecords = PaymentRecord::with('admin')
        ->where('homeowner_id', $id)
        ->orderByDesc('payment_date') // Order by payment date in descending order
        ->get();
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
    
        if ($fetchRecords->isEmpty()) {
            $monthsDifference = abs($diffMonths);
            $message = "You are behind by $monthsDifference months. Next payment is for " . date("F Y");
        } elseif ($monthsDifference > 0) {
            $message = "You are ahead by $monthsDifference months. Next payment is in " . date("F Y", strtotime("+ $monthsDifference months"));
        } elseif ($monthsDifference < 0) {
            $monthsDifference = abs($monthsDifference);
            $message = "You are behind by $monthsDifference months. Next payment is for " . date("F Y", strtotime("- $monthsDifference months"));
        } else {
            $message = "You are up to date. Last payment covered for " . date("F Y");
        }
    
        return response()->json(['records' => $fetchRecords, 'message' => $message], 200);
    }
    
    
    
    

    
    public function savePdfRecords($id)
    {
        // Fetch data and perform calculations as before
        $fetchRecords = PaymentRecord::with('admin')->with('homeowner')->where('homeowner_id', $id)->get();
        $fetchAllAmount = PaymentRecord::where('homeowner_id', $id)->pluck('payment_amount');
        $totalAmount = $fetchAllAmount->sum();
        $monthsToAdd = floor($totalAmount / 200);
        $currentMonth = date('n');
        $currentYear = date('Y');
        $startMonth = 0;
        $startYear = 2023;
        $diffYears = $startYear - $currentYear;
        $diffMonths = $startMonth - $currentMonth + ($diffYears * 12);
        $monthsDifference = $diffMonths + $monthsToAdd;

        if ($monthsDifference > 0) {
            $message = "You are ahead by $monthsDifference months. Next payment is in " . date("F Y", strtotime("+ $monthsDifference months"));
        } elseif ($monthsDifference < 0) {
            $monthsDifference = abs($monthsDifference);
            $message = "You are behind by $monthsDifference months. Next payment is for " . date("F Y", strtotime("- $monthsDifference months"));
        } else {
            $message = "You are up to date. Last payment covered for " . date("F Y");
        }

        // Generate the PDF using the service
        $pdfContent = $this->pdfGenerationService->generatePDF($fetchRecords, $totalAmount, $monthsToAdd, $message, $id);

        // Return the PDF as a response
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf');
    }
   
    
    
}
