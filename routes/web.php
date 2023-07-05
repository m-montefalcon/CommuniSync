<?php

use App\Http\Controllers\WebViewController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landingPage');
});

//WEB VIEWS ROUTES
Route::get('/login', [WebViewController::class, 'ReturnLoginWebView']);
Route::get('/register', [WebViewController::class, 'ReturnRegisterView']);