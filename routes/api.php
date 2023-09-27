<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockListController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ControlAccessController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\PaymentRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationRequests;
use App\Http\Controllers\WebViewController;
use App\Models\ControlAccess;
use App\Models\Logbook;
use App\Models\PaymentRecord;
use App\Models\VerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//COMMON ROUTES NAMING
//return[function]WebView - routes on views
//index - show all data or students
//show - show a single data 
//create - show a form to create a data
//store - store a data
//update - shows form to edit a data
//update - update a data
//destroy - delete a data
//auth - authenticate user



// Public routes
    Route::post('/register/store', [AuthController::class, 'store'])->name('api.register.store');
    Route::post('/login/store', [AuthController::class, 'login'])->name('api.login.store');

// User mobile APIs
    Route::post('/register/store/mobile', [AuthController::class, 'mobileStore'])->name('api.register.store.mobile');
    Route::post('/login/store/mobile', [AuthController::class, 'loginMobile'])->name('api.login.store.mobile');
// Other public routes...


// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // User APIs
        Route::put('/update/{id}', [UserController::class, 'update'])->name('api.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('api.delete');

    // User verification
        Route::put('/approved/verification/{id}', [VerificationRequests::class, 'update'])->name('api.approved.verification');
        Route::post('/verification/requests/store', [VerificationRequests::class, 'mobileStore'])->name('api.verification.requests.mobile');

        Route::post('/logout/store', [AuthController::class, 'logout'])->name('api.logout.store');
        Route::post('/logout/mobile', [AuthController::class, 'logoutMobile'])->name('api.logout.mobile');

    // Announcement feature
        Route::post('/announcement/store', [AnnouncementController::class, 'announcementStore'])->name('announcementStore');
        Route::get('/announcement/fetch/mobile', [AnnouncementController::class, 'announcementFetchMobile'])->name('announcementFetchMobile');

    // Control access feature 
    
        //Search homeowner username by visitor
        Route::post('users/control/access/search/mobile', [ControlAccessController::class, 'searchMobile'])->name('api.users.control.access.search.mobile');
        //Submit visit request by visitor
        Route::post('users/control/access/request/mobile', [ControlAccessController::class, 'requestMobile'])->name('api.users.control.access.request.mobile');
        //Get all request by homeowner
        Route::get('users/control/access/get/mobile/{id}', [ControlAccessController::class, 'getRequestHomeowner'])->name('users.control.access.get.mobile.{id}');
        //Decline the request by homeowner
        Route::put('users/control/access/decline/mobile', [ControlAccessController::class, 'declineMobile'])->name('api.users.control.access.decline.mobile');
        //Accept the request by homeowner
        Route::put('users/control/access/accept/mobile', [ControlAccessController::class, 'acceptMobile'])->name('api.users.control.access.accept.mobile');
        
        //Validated by admin the request
        Route::put('admin/control/access/validated/{id}', [ControlAccessController::class, 'validated'])->name('api.admin.control.access.validated');
        //Reject by admin the request
        
        //Return the qrcode info after scanning by personnel
        Route::post('users/control/access/recorded/check/mobile', [ControlAccessController::class, 'recordedCheckMobile'])->name('api.users.control.access.recorded.check.mobile');
        //Finally accept or returned blocked user by SP
        Route::put('users/control/access/recorded', [ControlAccessController::class, 'recordedMobile'])->name('api.users.control.access.recorded');

        Route::get('users/control/access/fetch/all/request/mobile/{id}', [ControlAccessController::class, 'fetchAllRequestMobile'])->name('api.users.control.access.fetch.all.request.mobile');
        Route::get('users/control/access/fetch/specific/request/mobile/{id}', [ControlAccessController::class, 'fetchSpecificRequestMobile'])->name('api.users.control.access.fetch.specific.request.mobile');

    // Blocklist feature
        Route::post('users/blocklists/request/mobile', [BlockListController::class, 'request'])->name('api.users.blocklists.request.mobile');
        Route::put('admin/blocklists/validated/mobile/{id}', [BlockListController::class, 'validated'])->name('api.admin.blocklists.validated.mobile');

    // Payment records
        Route::post('admin/payment/records/store', [PaymentRecordController::class, 'store'])->name('api.admin.payment.records.store');
        Route::get('admin/payment/records/get/all', [PaymentRecordController::class, 'getALl'])->name('api.admin.payment.records.get.all');
        Route::get('admin/payment/records/get/{id}', [PaymentRecordController::class, 'getId'])->name('api.admin.payment.records.get');

    // Complaint feature
        Route::post('user/complaint/store/mobile', [ComplaintController::class, 'storeMobile'])->name('api.user.complaint.store');
        Route::put('admin/complaint/update/{id}', [ComplaintController::class, 'update'])->name('api.admin.complaint.update');
        Route::put('admin/complaint/close/{id}', [ComplaintController::class, 'close'])->name('api.admin.complaint.close');

    // Manual visit options
        Route::get('mvo/get/homeowner', [LogbookController::class, 'get'])->name('mvo.get.homeowner');
        Route::post('mvo/post/homeowner/{id}', [LogbookController::class, 'post'])->name('mvo.post.homeowner');
});
