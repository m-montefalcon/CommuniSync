<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Logbook;
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\DB;
use App\Models\VerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class WebViewController extends Controller
{
    //USER ROUTES
    public function returnLandingPageView(){
        return view('user.landingPage');

    }
    public function returnLoginWebView(){
        return view('user.login');
    }

    public function returnRegisterVisitorView(){
        return view('user.registerVisitor');
    }

    public function returnRegisterHomeownerView(){
        return view('user.registerHomeowner');
    }

    public function returnRegisterPersonnelView(){
        return view('user.registerPersonnel');
    }

    public function returnRegisterAdminView(){
        return view('user.registerAdmin');
    }


    //CONTENTS ROUTES
    public function returnHomeView(){

        return view('content.home');
    }

    public function returnProfileView(){
        return view('content.profile');
    }

    public function showVisitor(){
        $visitors = User::checksRole(1);
        return view('content.visitor', compact('visitors'));
        
    }
    public function showHomeowner(){
        $homeowners = User::checksRole(2);
        return view('content.homeowner', compact('homeowners'));
    }
    public function showPersonnel(){
        $personnels = User::checksRole(3);
        return view('content.personnel', compact('personnels'));
    }
    public function showAdmin(){
        $admins = User::checksRole(4);
        return view('content.admin', compact('admins'));
    }

    public function showVisitorId($id){
        $visitor = User::findorFail($id);
    
        return view('credentialsForm.editVisitorForm', compact('visitor'));
       
    }

    public function showHomeownerId($id){
        $homeowner = User::findorFail($id);
        $homeowner->family_member = json_decode($homeowner->family_member, true);

        return view('credentialsForm.editHomeownerForm', compact('homeowner'));
    }

    public function showPersonnelId($id){
        $personnel = User::findorFail($id);
    
        return view('credentialsForm.editPersonnelForm', compact('personnel'));
    }
    public function showAdminId($id){
        $admin = User::findorFail($id);
    
        return view('credentialsForm.editAdminForm', compact('admin'));
    }
    public function showRequests()
    {
        $verifyRequests = VerificationRequest::with('user')->get();
        return view('verification.verificationRequest', compact('verifyRequests'));
    }

    public function show(){
        $announcements = Announcement::with('admin')->get();
        return view('announcement.announcement', compact('announcements'));
    }

    public function showCreateForm(){
        return view('announcement.announcementForm');
    }
    public function test(){
        $qrcodes  = ControlAccess::all('qr_code');

        return view('qrcode', compact('qrcodes'));
    }
    public function announcementFetchId($id){
        // $fetchRequests = Announcement::findOrFail($id)->get();
        $announcement = Announcement::findOrFail($id);
        return view('announcement.viewAnnouncement', compact('announcement'));

    }
    public function getAllCAF(){
        $fetchRequests = ControlAccess::with('visitor', 'homeowner')
        ->where('visit_status', '2')
        ->get();
        
        return view('accessControl.accessControl', compact('fetchRequests'));

    }

    public function fetch(){
        // $fetchALlComplaints =  Complaint::with('homeowner')->with('admin')->where('complaint_status', 1)->orWhere('complaint_status', 2)->get();
        $fetchALlComplaints = Complaint::status(1, 2)->with('homeowner', 'admin')->get();
        foreach ($fetchALlComplaints as $complaint) {
            $complaint->complaint_updates = json_decode($complaint->complaint_updates);
        }
        // @dd($fetchALlComplaints);
       return view('complaints.complaints', compact('fetchALlComplaints'));
    }
    public function fetchComplaintsHistory(){
        // $fetchALlComplaints =  Complaint::with('homeowner')->with('admin')->where('complaint_status', 1)->orWhere('complaint_status', 2)->get();
        $fetchALlComplaints = Complaint::where('complaint_status', 3)->get();
       return view('complaints.complaintsHistory', compact('fetchALlComplaints'));
    }
    
    public function getLb(){
        $fetchAllLb = Logbook::with('homeowner', 'admin', 'visitor', 'personnel')->get();
        return view('logbook', compact('fetchAllLb'));
    }

    public function fetchAllUserPayment(){
        $homeowners = User::checksRole(2);
        return view('payment.paymentRecord', compact('homeowners'));
    }


    public function getALl()
    {
        Paginator::useBootstrap();

        $fetchALlRecords = PaymentRecord::with('homeowner', 'admin')
            ->orderBy('payment_date', 'desc') // Order by payment date in descending order (latest first)
            ->paginate(20); // You can change the number 10 to the desired number of records per page
    
        return view('payment.paymentAllHistory', compact('fetchALlRecords'));
    }
    public function paymentFilter(Request $request) {
        // Retrieve the parameters from the request
        $fromMonth = $request->input('fromMonth');
        $fromYear = $request->input('fromYear');
        $toMonth = $request->input('toMonth');
        $toYear = $request->input('toYear');
    
        // Query PaymentRecords based on the date range
        $paymentRecords = PaymentRecord::with('homeowner')->with('admin')->whereBetween('payment_date', ["{$fromYear}-{$fromMonth}-01", "{$toYear}-{$toMonth}-31"])
            ->orderBy('payment_date', 'desc')
            ->get();
    
        // Add your logic to handle or return the filtered records
        return $this->generatePdfFromPaymentRecords($paymentRecords,$fromMonth, $fromYear,  $toMonth, $toYear);
    }
    
    public function generatePdfFromPaymentRecords($paymentRecords, $fromMonth, $fromYear, $toMonth, $toYear)
    {
      // Create a PDF instance
      $pdf = new Dompdf();
    
      // Set options for PDF generation (optional)
      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isPhpEnabled', true);
      $pdf->setOptions($options);
   
      // Calculate the total amount
      $totalAmount = $paymentRecords->sum('payment_amount');
    
      $html = '<html>';
      $html .= '<head>';
      $html .= '<title>Payment Records</title>';
      $html .= '<style>';
      $html .= 'body { font-family: Arial, sans-serif; margin: 20px; }';
      $html .= 'h1 { text-align: center; }';
      $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 10px; }';
      $html .= 'th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }';
      $html .= 'th { background-color: #f2f2f2; border-bottom: 2px solid #000; }';
      $html .= 'tr:nth-child(even) {background-color: #f9f9f9;}';
      $html .= '</style>';
      $html .= '<h1>GREENVILLE SUBDIVISION</h1>';
      $html .= '</head>';
      $html .= '<body>';
      $html .= '<h1>PAYMENT RECORD</h1>';
      $html .= '<p>From: ' . date('F Y', strtotime($fromYear . '-' . $fromMonth . '-01')) . '    To: ' . date('F Y', strtotime($toYear . '-' . $toMonth . '-31')) . '</p>';
      $html .= '<p>Total Amount: PHP' . number_format($totalAmount, 2) . '</p>';
      
      $html .= '<table>';
      $html .= '<tr><th>Homeowner Name</th><th>Admin Name</th><th>Payment Date</th><th>Payment Amount</th><th>Notes</th></tr>';
      foreach ($paymentRecords as $record) {
          $homeownerName = $record->homeowner->first_name . ' ' . $record->homeowner->last_name;
          $adminName = $record->admin->first_name . ' ' . $record->admin->last_name;
          $html .= "<tr><td>{$homeownerName}</td><td>{$adminName}</td><td>" . date('F j, Y', strtotime($record->payment_date)) . "</td><td>" . number_format($record->payment_amount, 2) . "</td><td>{$record->notes}</td></tr>";
      }
      $html .= '</table>';
      $html .= '<div style="position: fixed; bottom: 0; width: 100%; text-align: center;">';
      $html .= '</div>';
      $html .= '<p>This is a computer-generated document based on the recorded monthly due payment</p>';
      
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