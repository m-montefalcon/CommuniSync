<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\ValidatedData;
use App\Http\Requests\PaymentRecords\UserPaymentRequest;
use Dompdf\Dompdf;
use Dompdf\Options;


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
    
    

    
    public function savePdfRecords($id){

        $fetchRecords = PaymentRecord::with('admin')->with('homeowner')->where('homeowner_id', $id)->get();
        $fetchAllAmount = PaymentRecord::where('homeowner_id', $id)->pluck('payment_amount');
        $totalAmount = $fetchAllAmount->sum();
        $monthsToAdd = floor($totalAmount / 200);
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
        // Create a PDF instance
        $pdf = new Dompdf();
    
        // Set options for PDF generation (optional)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);
    
        $html = '<html>';
        $html .= '<head>';
        $html .= '<title>Monthly Due</title>';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; }';
        $html .= 'h1 { text-align: center; }';
        $html .= 'table { width: 100%; border-collapse: collapse; }';
        $html .= 'table, th, td { border: 1px solid #000; }';
        $html .= 'th, td { padding: 10px; text-align: left; }';
        $html .= 'th { background-color: #f2f2f2; }';
        $html .= 'td { vertical-align: top; }';
        $html .= 'strong { font-weight: bold; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<h1>GREENVILLE SUBDIVISION</h1>';
        $html .= '<h2>Monthly Due Records</h2>';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td width="50%"><strong>Name:</strong> ' . $fetchRecords[0]->homeowner->first_name . ' ' . $fetchRecords[0]->homeowner->last_name . '</td>';
        $html .= '<td width="50%" style="padding-left: 20px;"><strong>Address:</strong> Block ' . $fetchRecords[0]->homeowner->block_no . ', Lot ' . $fetchRecords[0]->homeowner->lot_no . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td><strong>Contact Number:</strong> ' . $fetchRecords[0]->homeowner->contact_number . '</td>';
        $html .= '<td style="padding-left: 20px;"><strong>Username:</strong> ' . $fetchRecords[0]->homeowner->user_name . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</br>';
        

        $html .= '<p>Total amount: ' . $totalAmount . '</p>';
        $html .= '<p>Months covered starting January 2023: ' . $monthsToAdd . ' Months' . '</p>';

        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<th>Admin Name</th>';
        $html .= '<th>Payment Date</th>';
        $html .= '<th>Transaction Number</th>';
        $html .= '<th>Payment Amount</th>';
        $html .= '<th>Notes</th>';
        $html .= '</tr>';

        foreach ($fetchRecords as $record) {
            $html .= '<tr>';
            $html .= '<td>' . $record->admin->first_name . ' ' . $record->admin->last_name . '</td>';
            $html .= '<td>' . $record->payment_date . '</td>';
            $html .= '<td>' . $record->transaction_number . '</td>';
            $html .= '<td>' . $record->payment_amount . '</td>';
            $html .= '<td>' . ($record->notes ?? 'none') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
        $html .= '<p>Status: ' . $message . '</p>';
        $html .= '</body>';
        $html .= '</html>';

        // Load HTML content into the PDF instance
        $pdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (output or save to file)
        $pdf->render();

    
        // Return the PDF as a response
        $pdfContent = $pdf->output();
        return response($pdfContent, 200)
        ->header('Content-Type', 'application/pdf');

    }
    
    
    
}
