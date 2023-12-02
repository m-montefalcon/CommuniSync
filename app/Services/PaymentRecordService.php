<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\PaymentRecord;

class PaymentRecordService
{
    public function getFilteredPaymentRecords($fromMonth, $fromYear, $toMonth, $toYear)
    {
        return PaymentRecord::with('homeowner')
            ->with('admin')
            ->whereBetween('payment_date', ["{$fromYear}-{$fromMonth}-01", "{$toYear}-{$toMonth}-31"])
            ->orderBy('payment_date', 'desc')
            ->get();
    }
    public function getFilteredPaymentRecordsHomeowner($id,$fromMonth, $fromYear, $toMonth, $toYear)
    {
        return PaymentRecord::with('homeowner')
            ->with('admin')
            ->where('homeowner_id', $id)
            ->whereBetween('payment_date', ["{$fromYear}-{$fromMonth}-01", "{$toYear}-{$toMonth}-31"])
            ->orderBy('payment_date', 'desc')
            ->get();
    }
    public function generatePaymentRecordsPdf($paymentRecords, $fromMonth, $fromYear, $toMonth, $toYear)
    {
        // Calculate the total amount
        $totalAmount = $paymentRecords->sum('payment_amount');

        // Calculate the date strings
        $fromDate = date('F Y', strtotime($fromYear . '-' . $fromMonth . '-01'));
        $toDate = date('F Y', strtotime($toYear . '-' . $toMonth . '-31'));

        // Heredoc syntax for cleaner HTML string
        $html = <<<HTML
        <html>
        <head>
        <title>Payment Records</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
            th { background-color: #f2f2f2; border-bottom: 2px solid #000; }
            tr:nth-child(even) {background-color: #f9f9f9;}
        </style>
        </head>
        <body>
        <h1>GREENVILLE SUBDIVISION</h1>
        <h1>PAYMENT RECORD</h1>
        <p>From: {$fromDate} To: {$toDate}</p>
        <p>Total Amount: PHP{$totalAmount}</p>
        
        <table>
            <tr><th>Homeowner Name</th><th>Posted By</th><th>Payment Date</th><th>Payment Amount</th><th>Remarks</th></tr>
        HTML;


        foreach ($paymentRecords as $record) {
            $homeownerName = $record->homeowner->first_name . ' ' . $record->homeowner->last_name;
            $adminName = $record->admin->first_name . ' ' . $record->admin->last_name;
            $html .= "<tr><td>{$homeownerName}</td><td>{$adminName}</td><td>" . date('F j, Y', strtotime($record->payment_date)) . "</td><td>" . number_format($record->payment_amount, 2) . "</td><td>{$record->notes}</td></tr>";
        }

        $html .= <<<HTML
            </table>
            <div style="position: fixed; bottom: 0; width: 100%; text-align: center;"></div>
            <p>This is a computer-generated document based on the recorded monthly due payment</p>
        </body>
        </html>
        HTML;

        // Create a PDF instance
        $pdf = new Dompdf();

        // Set options for PDF generation (optional)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);

        // Load HTML content into the PDF instance
        $pdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (output or save to file)
        $pdf->render();

        // Return the PDF content
        return $pdf->output();
    }
    public function generatePDF($fetchRecords, $totalAmount, $monthsToAdd, $message, $homeownerId)
    {
        // Create a PDF instance
        $pdf = new Dompdf();
    
        // Set options for PDF generation (optional)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);
    
        // Generate HTML content for the PDF
        $html = $this->generateHTML($fetchRecords, $totalAmount, $monthsToAdd, $message, $homeownerId);
    
        // Load HTML content into the PDF instance
        $pdf->loadHtml($html);
    
        // Set paper size and orientation (optional)
        $pdf->setPaper('A4', 'portrait');
    
        // Render PDF (output or save to file)
        $pdf->render();
    
        // Return the PDF content
        return $pdf->output();
    }
    
    private function generateHTML($fetchRecords, $totalAmount, $monthsToAdd, $message, $homeownerId)
    {
        // Initialize variables with default values
        $name = $address = $contactNumber = $username = '';
    
        // Find the User based on the homeowner_id
        $user = User::find($homeownerId);
    
        // Check if $user is not null
        if (!empty($user)) {
            // Assign values only if they are not null
            $name = $user->first_name . ' ' . $user->last_name;
            $address = 'Block ' . $user->block_no . ', Lot ' . $user->lot_no;
            $contactNumber = $user->contact_number;
            $username = $user->user_name;
        }
    
        // Generate HTML content using concatenation
        $html = '<html>' .
            '<head>' .
            '<title>Monthly Due</title>' .
            '<style>' .
            'body { font-family: Arial, sans-serif; margin: 20px; }' .
            'h1 { text-align: center; }' .
            'table { width: 100%; border-collapse: collapse; margin-top: 10px; }' .
            'th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }' .
            'th { background-color: #f2f2f2; border-bottom: 2px solid #000; }' .
            'tr:nth-child(even) {background-color: #f9f9f9;}' .
            '</style>' .
            '</head>' .
            '<body>' .
            '<h1>GREENVILLE SUBDIVISION</h1>' .
            '<h1>Monthly Due Record</h1>' .
            '<table>' .
            '<tr>' .
            '<td width="50%"><strong>Homeowner ID:</strong> ' . $homeownerId . '</td>' .
            '<td width="50%"><strong>Name:</strong> ' . $name . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td><strong>Contact Number:</strong> ' . $contactNumber . '</td>' .
            '<td><strong>Username:</strong> ' . $username . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td colspan="2"><strong>Address:</strong> ' . $address . '</td>' .
            '</tr>' .
            '</table>' .
            '<br>' .
            '<p>Total amount: PHP ' . ($totalAmount ?? '0.00') . '</p>' .
            '<p>Months covered starting January 2023: ' . ($monthsToAdd ?? '0') . ' Months' . '</p>' .
            '<table>' .
            '<tr>' .
            '<th>Posted By</th>' .
            '<th>Payment Date</th>' .
            '<th>Transaction Number</th>' .
            '<th>Payment Amount</th>' .
            '<th>Remarks</th>' .
            '</tr>';
    
        // Check if records are available
        if (!empty($fetchRecords)) {
            foreach ($fetchRecords as $record) {
                // Check if the necessary properties are not null
                $adminName = isset($record->admin) ? $record->admin->first_name . ' ' . $record->admin->last_name : 'N/A';
                $paymentDate = isset($record->payment_date) ? $record->payment_date : 'N/A';
                $transactionNumber = isset($record->transaction_number) ? $record->transaction_number : 'N/A';
                $paymentAmount = isset($record->payment_amount) ? $record->payment_amount : 'N/A';
                $remarks = isset($record->notes) ? $record->notes : 'none';
    
                $html .= '<tr>' .
                    '<td>' . $adminName . '</td>' .
                    '<td>' . $paymentDate . '</td>' .
                    '<td>' . $transactionNumber . '</td>' .
                    '<td>' . $paymentAmount . '</td>' .
                    '<td>' . $remarks . '</td>' .
                    '</tr>';
            }
        } else {
            // Display "No Records Found" message
            $html .= '<tr><td colspan="5">No Records Found</td></tr>';
        }
    
        $html .= '</table>' .
            '<p>Status: ' . ($message ?? 'N/A') . '</p>' .
            '</body>' .
            '</html>';
    
        return $html;
    }
    

    
    
    
}


    

