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


//--------------------------------------USER WEB VIEWS ROUTES-------------------------------------------//
Route::get('/', [WebViewController::class, 'returnLandingPageView'])->middleware('guest');
Route::get('/login', [WebViewController::class, 'returnLoginWebView'])->name('login')->middleware('guest');
Route::get('/register', [WebViewController::class, 'returnRegisterView'])->middleware('guest');

//--------------------------------------CONTENTS WEB ROUTES-------------------------------------------//
Route::get('/home', [WebViewController::class, 'returnHomeView'])->middleware('auth')->name('home');
Route::get('profile', [WebViewController::class, 'returnProfileView'])->middleware('auth')->name('profile');
Route::get('visitor', [WebViewController::class, 'showVisitor'])->middleware('auth')->name('visitor');
Route::get('homeowner', [WebViewController::class, 'showHomeowner'])->middleware('auth')->name('homeowner');
Route::get('personnel', [WebViewController::class, 'showPersonnel'])->middleware('auth')->name('personnel');
Route::get('admin', [WebViewController::class, 'showAdmin'])->middleware('auth')->name('admin');

//--------------------------------------SHOW SPECIFIC USER DETAILS ROUTE-------------------------------------------//
Route::get('/visitor/{id}', [WebViewController::class, 'showVisitorId'])->middleware('auth')->name('visitorId');
Route::get('/homeowner/{id}', [WebViewController::class, 'showHomeownerId'])->middleware('auth')->name('homeownerId');
Route::get('/personnel/{id}', [WebViewController::class, 'showPersonnelId'])->middleware('auth')->name('personnelId');
Route::get('/admin/{id}', [WebViewController::class, 'showAdminId'])->middleware('auth')->name('adminId');

//--------------------------------------USER VERIFCATION-------------------------------------------//
Route::get('/verification/requests', [WebViewController::class, 'showRequests'])->middleware('auth')->name('verificationRequests');

//--------------------------------------ANNOUNCEMENTS-------------------------------------------//
Route::get('/announcement', [WebViewController::class, 'show'])->middleware('auth')->name('announcement');
Route::get('/announcement/create/form', [WebViewController::class, 'showCreateForm'])->middleware('auth')->name('announcement.form');

//--------------------------------------QR CODE TESTING CAF-------------------------------------------//

Route::get('/test/qrcode', [WebViewController::class, 'test'])->name('test');

//--------------------------------------CSRF TOKEN FOR API TESTING-------------------------------------------//

Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});
