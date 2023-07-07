<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//USER API
Route::post('/register/store', [AuthController::class, 'store'])->name('api.register.store');
Route::post('/login/store', [AuthController::class, 'login'])->name('api.login.store');
Route::post('/logout/store', [AuthController::class, 'logout'])->middleware('auth')->name('api.logout');

//USER EDIT CREDENTIALS
Route::put('/update/{id}', [UserController::class, 'update'])->middleware('auth')->name('api.update');
Route::delete('/delete/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('api.delete');

