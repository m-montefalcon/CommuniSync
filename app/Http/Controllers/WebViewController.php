<?php

namespace App\Http\Controllers;
use DateTime;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Logbook;
use App\Models\BlockList;
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ControlAccess;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\DB;
use App\Models\VerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Services\PaymentRecordService;
use Illuminate\Support\Facades\Response;

class WebViewController extends Controller
{
    protected $paymentRecordService;

    public function __construct(PaymentRecordService $paymentRecordService)
    {
        $this->paymentRecordService = $paymentRecordService;
    }
    //USER ROUTES
    public function returnLandingPageView(){
        return view('user.landingPage');

    }

    public function returnTermsAndCondition() {
        return view('user.termsAndCondition');
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

    public function showVisitor(Request $request){
        $fetchAllVisitor = User::checksRole(1)->latest();
    
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $fetchAllVisitor->search($searchTerm);
        }
    
        $visitors = $fetchAllVisitor->paginate(2);
    
        // Append the search query to the pagination links
        $visitors->appends(['search' => $request->input('search')]);
    
        return view('content.visitor', compact('visitors'));
        
    }
    public function showHomeowner(Request $request)
    {
        $fetchAllHomeowner = User::checksRole(2)->latest();
    
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $fetchAllHomeowner->search($searchTerm);
        }
    
        $homeowners = $fetchAllHomeowner->paginate(2);
    
        // Append the search query to the pagination links
        $homeowners->appends(['search' => $request->input('search')]);
    
        return view('content.homeowner', compact('homeowners'));
    }
    
    public function showPersonnel(Request $request){

        $fetchAllPersonnel = User::checksRole(3)->latest();
    
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $fetchAllPersonnel->search($searchTerm);
        }
    
        $personnels = $fetchAllPersonnel->paginate(2);
    
        // Append the search query to the pagination links
        $personnels->appends(['search' => $request->input('search')]);
        return view('content.personnel', compact('personnels'));
    }
    public function showAdmin(Request $request){
        
        $fetchAllAdmin = User::checksRole(4)->latest();
    
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $fetchAllAdmin->search($searchTerm);
        }
    
        $admins = $fetchAllAdmin->paginate(2);
    
        // Append the search query to the pagination links
        $admins->appends(['search' => $request->input('search')]);
 
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
    public function getLb(Request $request)
    {
        $fetchAllLb = Logbook::with('homeowner', 'admin', 'visitor', 'personnel')->latest();
    
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $fetchAllLb->search($searchTerm);
        }
    
        $fetchAllLb = $fetchAllLb->paginate(1)->appends(request()->query());
    
        return view('logbook', compact('fetchAllLb', 'request'));
    }


    
    public function fetchAllUserPayment(){
        $homeowners = User::checksRole(2)->get();
        return view('payment.paymentRecord', compact('homeowners'));
    }


    public function getALl()
    {
        Paginator::useBootstrap();

        $fetchALlRecords = PaymentRecord::with('homeowner', 'admin')
            ->orderBy('payment_date', 'desc') // Order by payment date in descending order (latest first)
            ->paginate(10); // You can change the number 10 to the desired number of records per page
    
        return view('payment.paymentAllHistory', compact('fetchALlRecords'));
    }


   
    
    public function paymentFilter(Request $request)
    {
        // Retrieve the parameters from the request
        $fromMonth = $request->input('fromMonth');
        $fromYear = $request->input('fromYear');
        $toMonth = $request->input('toMonth');
        $toYear = $request->input('toYear');

        // Query PaymentRecords based on the date range
        $paymentRecords = $this->paymentRecordService->getFilteredPaymentRecords($fromMonth, $fromYear, $toMonth, $toYear);

        // Return the PDF as a response
        return response($this->paymentRecordService->generatePaymentRecordsPdf($paymentRecords, $fromMonth, $fromYear, $toMonth, $toYear), 200)
            ->header('Content-Type', 'application/pdf');
    }







    
    public function showBlockedListsRequests(){
        $blocklists = BlockList::with('homeowner')->where('blocked_status', 1)->get();
        return view('blockedLists.blockedLists', compact('blocklists'));

    }

    public function showBlockedLists(){
        $blocklists = BlockList::with('homeowner')->with('admin')->where('blocked_status', 2)->get();
        return view('blockedLists.contactLists', compact('blocklists'));
    }
    
    
}