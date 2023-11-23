// LogbookService.php

<?php
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;

class LogbookService
{
    public function generatePdfFromLogbook($logbookEntries, $fromDate, $toDate)
    {
        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);

        $html = $this->generateLogbookHtml($logbookEntries, $fromDate, $toDate);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdfContent = $pdf->output();
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=logbook.pdf',
        ]);
    }

    public function generateLogbookHtml($logbookEntries, $fromDate, $toDate)
{
    $html = <<<HTML
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; border-bottom: 2px solid #000; }
        tr:nth-child(even) {background-color: #f9f9f9;}
        .title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>GREENVILLE SUBDIVISION</h1>
    <h1>Logbook Records</h1>
    <p class="title">From: $fromDate To: $toDate</p>
    <table>
        <tr>
            <th>Visitor</th>
            <th>Homeowner</th>
            <th>Admin</th>
            <th>Personnel</th>
            <th>Destination Person</th>
            <th>Contact Number</th>
            <th>Visit In</th>
            <th>Visit Out</th>
            <th>Visit Members</th>
        </tr>
HTML;

    foreach ($logbookEntries as $entry) {
        $html .= <<<HTML
        <tr>
            <td>{optional($entry->visitor)->first_name} {optional($entry->visitor)->last_name}</td>
            <td>{optional($entry->homeowner)->first_name} {optional($entry->homeowner)->last_name}</td>
            <td>{optional($entry->admin)->first_name} {optional($entry->admin)->last_name}</td>
            <td>{optional($entry->personnel)->first_name} {optional($entry->personnel)->last_name}</td>
            <td>{$entry->destination_person}</td>
            <td>{$entry->contact_number}</td>
            <td>{$entry->visit_date_in} {$entry->visit_time_in}</td>
            <td>{($entry->visit_date_out ? $entry->visit_date_out . ' ' . $entry->visit_time_out : 'Currently In')}</td>
HTML;

        $visitMembers = json_decode($entry->visit_members);

        $html .= <<<HTML
            <td>
HTML;

        if ($visitMembers === null) {
            $html .= 'No member found';
        } elseif (is_array($visitMembers)) {
            $html .= implode(", ", $visitMembers);
        } else {
            $html .= $visitMembers;
        }

        $html .= <<<HTML
            </td>
        </tr>
HTML;
    }

    $html .= <<<HTML
    </table>
</body>
</html>
HTML;

    return $html;
}



}
