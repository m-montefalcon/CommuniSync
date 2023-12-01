<?php

namespace App\Services;

use App\Models\PaymentRecord;
use Dompdf\Dompdf;
use Dompdf\Options;

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
    public function generatePDF($fetchRecords, $totalAmount, $monthsToAdd, $message)
    {
        // Create a PDF instance
        $pdf = new Dompdf();

        // Set options for PDF generation (optional)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);

        // Generate HTML content for the PDF
        $html = $this->generateHTML($fetchRecords, $totalAmount, $monthsToAdd, $message);

        // Load HTML content into the PDF instance
        $pdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (output or save to file)
        $pdf->render();

        // Return the PDF content
        return $pdf->output();
    }
    private function generateHTML($fetchRecords, $totalAmount, $monthsToAdd, $message)
    {
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
            '<td width="50%"><strong>Name:</strong> ' . $fetchRecords[0]->homeowner->first_name . ' ' . $fetchRecords[0]->homeowner->last_name . '</td>' .
            '<td width="50%" style="padding-left: 20px;"><strong>Address:</strong> Block ' . $fetchRecords[0]->homeowner->block_no . ', Lot ' . $fetchRecords[0]->homeowner->lot_no . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td><strong>Contact Number:</strong> ' . $fetchRecords[0]->homeowner->contact_number . '</td>' .
            '<td style="padding-left: 20px;"><strong>Username:</strong> ' . $fetchRecords[0]->homeowner->user_name . '</td>' .
            '</tr>' .
            '</table>' .
            '<br>' .
            '<p>Total amount: PHP ' . $totalAmount . '</p>' .
            '<p>Months covered starting January 2023: ' . $monthsToAdd . ' Months' . '</p>' .
            '<table>' .
            '<tr>' .
            '<th>Posted By</th>' .
            '<th>Payment Date</th>' .
            '<th>Transaction Number</th>' .
            '<th>Payment Amount</th>' .
            '<th>Remarks</th>' .
            '</tr>';
    
        foreach ($fetchRecords as $record) {
            $html .= '<tr>' .
                '<td>' . $record->admin->first_name . ' ' . $record->admin->last_name . '</td>' .
                '<td>' . $record->payment_date . '</td>' .
                '<td>' . $record->transaction_number . '</td>' .
                '<td>' . $record->payment_amount . '</td>' .
                '<td>' . ($record->notes ?? 'none') . '</td>' .
                '</tr>';
        }
    
        $html .= '</table>' .
            '<p>Status: ' . $message . '</p>' .
            '</body>' .
            '</html>';
    
        return $html;
    }
    
}


    

