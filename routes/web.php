<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebViewController;
use App\Http\Controllers\VerificationRequests;
use App\Http\Controllers\AnnouncementController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//COMMON ROUTES NAMING
//return[function]WebView - routes on views
//index - show all data or students
//show - show a single data 
//create - show a form to create a data
//store - store a data
//edit - shows form to edit a data
//update - update a data
//destroy - delete a data



Route::get('/', [WebViewController::class, 'returnLandingPageView'])->middleware('guest');
Route::get('/login', [WebViewController::class, 'returnLoginWebView'])->name('login')->middleware('guest');
Route::get('/registerVisitor', [WebViewController::class, 'returnRegisterVisitorView'])->name('registerVisitor');
Route::get('/registerHomeowner', [WebViewController::class, 'returnRegisterHomeownerView'])->name('registerHomeowner');
Route::get('/registerPersonnel', [WebViewController::class, 'returnRegisterPersonnelView'])->name('registerPersonnel');
Route::get('/registerAdmin', [WebViewController::class, 'returnRegisterAdminView'])->name('registerAdmin');

// QR Code Testing CAF
Route::get('/test/qrcode', [WebViewController::class, 'test'])->name('test');

// CSRF Token for API Testing
Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});


// Protect the routes that require authentication with the sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Home
    Route::get('/home', [WebViewController::class, 'returnHomeView'])->name('home');
    // Profile
    Route::get('/profile', [WebViewController::class, 'returnProfileView'])->name('profile');
    // Visitor
    Route::get('/visitor', [WebViewController::class, 'showVisitor'])->name('visitor');
    // Homeowner
    Route::get('/homeowner', [WebViewController::class, 'showHomeowner'])->name('homeowner');
    // Personnel
    Route::get('/personnel', [WebViewController::class, 'showPersonnel'])->name('personnel');
    // Admin
    Route::get('/admin', [WebViewController::class, 'showAdmin'])->name('admin');

    // Show specific user details
    Route::get('/visitor/{id}', [WebViewController::class, 'showVisitorId'])->name('visitorId');
    Route::get('/homeowner/{id}', [WebViewController::class, 'showHomeownerId'])->name('homeownerId');
    Route::get('/personnel/{id}', [WebViewController::class, 'showPersonnelId'])->name('personnelId');
    Route::get('/admin/{id}', [WebViewController::class, 'showAdminId'])->name('adminId');

    // User verification requests
    Route::get('/verification/requests', [WebViewController::class, 'showRequests'])->name('verificationRequests');

    // Announcements
    Route::get('/announcement', [WebViewController::class, 'show'])->name('announcement');
    Route::get('/announcement/create/form', [WebViewController::class, 'showCreateForm'])->name('announcement.form');
    Route::get('/announcement/fetch/{id}', [WebViewController::class, 'announcementFetchId'])->name('announcementFetchId');

    //THIS IS FOR ADMIN TO SEE
    Route::get('users/control/access/get/all', [WebViewController::class, 'getAllCAF'])->name('users.control.access.get.all');

    // Complaints
    Route::get('admin/complaint/fetch', [WebViewController::class, 'fetch'])->name('api.admin.complaint.fetch');

    Route::get('admin/complaint/history/fetch', [WebViewController::class, 'fetchComplaintsHistory'])->name('api.admin.complaint.history.fetch');

    //Logbook
    Route::get('admin/get/logbook', [WebViewController::class, 'getLb'])->name('admin.get.logobok');
});

