<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ComplaintService
{
    public function generateAndShowPdfInNewTab($complaintId)
    {
        // Retrieve complaint data
        $complaint = Complaint::with('homeowner')->findOrFail($complaintId);
        $adminName = Auth::user()->first_name . ' ' . Auth::user()->last_name;

        // Extract required data
        $complaintData = [
            'created_at' => $complaint->created_at,
            'complaint_title' => $complaint->complaint_title,
            'complaint_desc' => $complaint->complaint_desc,
            'complaint_date' => $complaint->complaint_date,
            'homeowner_name' => $complaint->homeowner->first_name . ' ' . $complaint->homeowner->last_name,
            'homeowner_address' =>  $complaint->homeowner->address, // Fill in the homeowner's address
            'homeowner_contact' => $complaint->homeowner->contact_number,
            'homeowner_email' => $complaint->homeowner->email, // Fill in the homeowner's email
            'admin_name' => $adminName, // Fill in the admin's name
            'current_date' => now()->format('Y-m-d'), // Current date
        ];

        // Create dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Instantiate dompdf
        $dompdf = new Dompdf($options);

        // Define your HTML content here (replace this with your actual HTML)
        $html = $this->generateComplaintHtml($complaintData);

        // Load HTML content into dompdf
        $dompdf->loadHtml($html);

        // Set paper size
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output)
        $dompdf->render();

        // Get the PDF content
        $output = $dompdf->output();

        // Set the Content-Disposition to inline, so it opens in the browser
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=complaint.pdf',
        ];

        // Return the PDF content with the headers
        $response = Response::make($output, 200, $headers);

        // Send the response
        $response->send();
    }
    
    protected function generateComplaintHtml($complaintData)
    {
        return '
            <html>
                <head>
                    <title>Complaint PDF</title>
                    <style>
                        body {
                            font-family: "Times New Roman", Times, serif;
                            line-height: 1.6;
                            margin: 0 auto;
                            max-width: 600px;
                        }
                        h1 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        h2 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        address {
                            margin-bottom: 20px;
                        }
                        strong {
                            font-weight: bold;
                        }
                        em {
                            font-style: italic;
                        }
                        ol {
                            margin-left: 20px;
                        }
                        p {
                            margin-bottom: 10px;
                        }
                        .indent {
                            margin-left: 20px;
                        }
                    </style>
                </head>
                <body>
                    <h2>Greenville Subdivision Homeowners Association</h2>
                    <h1>COMPLAINT REPORT</h1>
    
                    <address>
                        <p>
                            <strong>' . $complaintData['homeowner_name'] . '</strong>
                            ' . $complaintData['homeowner_address'] . '<br>
                            ' . $complaintData['homeowner_email'] . '<br>
                            ' . $complaintData['homeowner_contact'] . '
                        </p>
                    </address>
    
                    <address>
                        <strong>Greenville Subdivision Homeowners Association (GHOA), <br></strong>
                        Greenville Subdivision, Barangay Bugo,<br>
                        Cagayan de Oro, Misamis Oriental, 9000
                    </address>
                    
                    <p><strong>Subject:</strong> Formal Complaint Report Regarding <strong>' . $complaintData['complaint_title'] . '</strong></p>
    
                    <p><strong>Date:</strong> ' . $complaintData['current_date'] . '</p>
    
                    <p>
                        <strong>To:</strong> Subdivision Management
                    </p>
    
                    <ol>
                        <li><strong>Incident Details:</strong></li>
                        <ul>
                            <li><strong>Date and Time of Incident:</strong> ' . $complaintData['created_at'] . '</li>
                            <li class="indent">
                                <strong>Nature of Complaint:</strong><br>
                                ' . $complaintData['complaint_desc'] . '
                            </li>                                
                        </ul>
                       
                    </ol>
                    <p style="text-indent: 40px; text-align: justify;">
                    This formal complaint, issued by the administration, is an official submission to the Greenville Subdivision Homeowners Association. It is to formally seek acknowledgment of this complaint and commitment to periodic updates on the investigation and resolution progress. Consider this document as an official record, designated for meticulous review by the Greenville Subdivision Homeowners Association. To expedite the process, active participation and cooperation from involved individuals, events, or entities are expected and encouraged.
                    </p>
                    
                
    
                    <p><strong>Sincerely,</strong></p>
                    <p>' . $complaintData['admin_name'] . '</p>
                    <p><strong> Greenville Subdivision Homeowners Association (GHOA) </strong></p>
                </body>
            </html>';
    }
    
    
    public function historyGenerateAndShowPdfInNewTab($complaintId)
    {
        
        // Retrieve complaint data
        $complaint = Complaint::with('homeowner')->with('admin')->findOrFail($complaintId);
        
        $adminName = Auth::user()->first_name . ' ' . Auth::user()->last_name;

        // Extract required data
        $complaintData = [
            'admin_name' => $complaint->admin->first_name . ' ' . $complaint->admin->last_name,
            'complaint_updates' => $complaint->complaint_updates,
            'created_at' => $complaint->created_at,
            'complaint_title' => $complaint->complaint_title,
            'complaint_desc' => $complaint->complaint_desc,
            'complaint_date' => $complaint->complaint_date,
            'homeowner_name' => $complaint->homeowner->first_name . ' ' . $complaint->homeowner->last_name,
            'homeowner_address' =>  $complaint->homeowner->address, // Fill in the homeowner's address
            'homeowner_contact' => $complaint->homeowner->contact_number,
            'homeowner_email' => $complaint->homeowner->email, // Fill in the homeowner's email
            'admin_name' => $adminName, // Fill in the admin's name
            'current_date' => now()->format('Y-m-d'), // Current date
        ];

        // Create dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Instantiate dompdf
        $dompdf = new Dompdf($options);

        // Define your HTML content here (replace this with your actual HTML)
        $html = $this->historyGenerateComplaintHtml($complaintData);

        // Load HTML content into dompdf
        $dompdf->loadHtml($html);

        // Set paper size
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output)
        $dompdf->render();

        // Get the PDF content
        $output = $dompdf->output();

        // Set the Content-Disposition to inline, so it opens in the browser
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=complaint.pdf',
        ];

        // Return the PDF content with the headers
        $response = Response::make($output, 200, $headers);

        // Send the response
        $response->send();
    }

    protected function historyGenerateComplaintHtml($complaintData)
    {
        // Extract complaint updates
        $complaintUpdates = json_decode($complaintData['complaint_updates'], true);

        // Generate HTML for complaint updates
        $updatesHtml = '<ul>';

        if ($complaintUpdates && is_array($complaintUpdates)) {
            foreach ($complaintUpdates as $update) {
                $updatesHtml .= '<li style="margin-bottom: 20px;">';
                $updatesHtml .= 'Date: ' . $update['date'] . '&nbsp;&nbsp;&nbsp;';

                if (isset($update['update'])) {
                    $updatesHtml .= 'Update: ' . $update['update'];
                } elseif (isset($update['resolution'])) {
                    $updatesHtml .= 'Resolution: ' . $update['resolution'];
                }

                $updatesHtml .= '</li>';
            }
        } else {
            $updatesHtml .= '<li>No updates available.</li>';
        }

        $updatesHtml .= '</ul>';
    


        return '
            <html>
                <head>
                    <title>Complaint PDF</title>
                    <style>
                        body {
                            font-family: "Times New Roman", Times, serif;
                            line-height: 1.6;
                            margin: 0 auto;
                            max-width: 600px;
                        }
                        h1 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        h2 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        address {
                            margin-bottom: 20px;
                        }
                        strong {
                            font-weight: bold;
                        }
                        em {
                            font-style: italic;
                        }
                        ol {
                            margin-left: 20px;
                        }
                        p {
                            margin-bottom: 10px;
                        }
                        .indent {
                            margin-left: 20px;
                        }
                    </style>
                </head>
                <body>
                    <h2>Greenville Subdivision Homeowners Association</h2>
                    <h1>COMPLAINT REPORT</h1>
    
                    <address>
                        <p>
                            <strong>' . $complaintData['homeowner_name'] . '</strong>
                            ' . $complaintData['homeowner_address'] . '<br>
                            ' . $complaintData['homeowner_email'] . '<br>
                            ' . $complaintData['homeowner_contact'] . '
                        </p>
                    </address>
    
                    <address>
                        <strong>Greenville Subdivision Homeowners Association (GHOA), <br></strong>
                        Greenville Subdivision, Barangay Bugo,<br>
                        Cagayan de Oro, Misamis Oriental, 9000
                    </address>
                    
                    <p><strong>Subject:</strong> Formal Complaint Report Regarding <strong>' . $complaintData['complaint_title'] . '</strong></p>
    
                    <p><strong>Date:</strong> ' . $complaintData['current_date'] . '</p>
    
                    <p>
                        <strong>To:</strong> Subdivision Management
                    </p>
    
                    <ol>
                        <li><strong>Incident Details:</strong></li>
                        <ul>
                            <li><strong>Date and Time of Incident:</strong> ' . $complaintData['created_at'] . '</li>
                            <li class="indent">
                                <strong>Nature of Complaint:</strong><br>
                                ' . $complaintData['complaint_desc'] . '
                            </li>   
                            <li class="indent">
                            <strong>Complaint closed by :</strong><br>
                            ' . $complaintData['admin_name'] . '
                             </li> 
                            <li><strong>Timeline Updates</strong></li>
   
                            ' . $updatesHtml . '
                          
                        </ul>

                    </ol>

                    <p style="text-indent: 40px; text-align: justify;">
                    This document serves as a formal notification to confirm the resolution of the previously filed complaint. The purpose of this report is to officially acknowledge that the complaint in question has been thoroughly addressed and resolved to the satisfaction of all concerned parties. This document stands as an official record indicating the successful resolution of the reported issue.
                    </p>
                    
                
    
                    <p><strong>Sincerely,</strong></p>
                    <p>' . $complaintData['admin_name'] . '</p>
                    <p><strong> Greenville Subdivision Homeowners Association (GHOA) </strong></p>
                </body>
            </html>';
    }
}
