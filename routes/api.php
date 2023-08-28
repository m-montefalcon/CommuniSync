<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockListController;
use App\Http\Controllers\ControlAccessController;
use App\Http\Controllers\PaymentRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationRequests;
use App\Models\ControlAccess;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//--------------------------------------USER APIS--------------------------------------------//
Route::post('/register/store', [AuthController::class, 'store'])->name('api.register.store');
Route::post('/login/store', [AuthController::class, 'login'])->name('api.login.store');
Route::post('/logout/store', [AuthController::class, 'logout'])->middleware('auth')->name('api.logout.store');
Route::put('/update/{id}', [UserController::class, 'update'])->middleware('auth')->name('api.update');
Route::delete('/delete/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('api.delete');


//--------------------------------------USER VERIFICATION--------------------------------------------//
Route::put('/approved/verification/{id}', [VerificationRequests::class, 'update'])->name('api.approved.verification');
Route::post('/verification/requests/store', [VerificationRequests::class, 'mobileStore'])->name('api.verification.requests.mobile');

//-------------------------------------- USER MOBILE APIS--------------------------------------------//
Route::post('/register/store/mobile', [AuthController::class, 'mobileStore'])->name('api.register.store.mobile');
Route::post('/login/store/mobile', [AuthController::class, 'loginMobile'])->name('api.logi.store.mobile');

//-----------------------------------------ANNOUNCEMENT FEATURE--------------------------------//
Route::post('/announcement/store', [AnnouncementController::class, 'announcementStore'])->name('announcementStore');
Route::get('/announcement/fetch/mobile', [AnnouncementController::class, 'announcementFetchMobile'])->name('announcementFetchMobile');


//-----------------------------------------CONTROL ACCESS FEATURE--------------------------------//
Route::get('users/control/access/search/mobile', [ControlAccessController::class, 'searchMobile'])->name('api.users.control.access.search.mobile');
Route::post('users/control/access/request/mobile', [ControlAccessController::class, 'requestMobile'])->name('api.users.control.access.request.mobile');
Route::put('users/control/access/accept/mobile', [ControlAccessController::class, 'acceptMobile'])->name('api.users.control.access.accept.mobile');
Route::put('admin/control/access/validated/{id}', [ControlAccessController::class, 'validated'])->name('api.admin.control.access.validated');
Route::put('users/control/access/recorded/mobile', [ControlAccessController::class, 'recordedMobile'])->name('api.users.control.access.recorded.mobile');
Route::get('users/control/access/fetch/all/request/mobile/{id}', [ControlAccessController::class, 'fetchAllRequestMobile'])->name('api.users.control.access.fetch.all.request.mobile');
Route::get('users/control/access/fetch/specific/request/mobile/{id}', [ControlAccessController::class, 'fetchSpecificRequestMobile'])->name('api.users.control.access.fetch.specific.request.mobile');


//-----------------------------------------BLOCKLIST FEATURE--------------------------------//
Route::post('users/blocklists/request/mobile', [BlockListController::class, 'request'])->name('api.users.blocklists.request.mobile');
Route::put('admin/blocklists/validated/mobile/{id}', [BlockListController::class, 'validated'])->name('api.admin.blocklists.validated.mobile');


//-----------------------------------------PAYMENT METHOD--------------------------------//
Route::post('admin/payment/records/store', [PaymentRecordController::class, 'store'])->name('api.admin.payment.records.store');
Route::get('admin/payment/records/get/all', [PaymentRecordController::class, 'getALl'])->name('api.admin.payment.records.get.all');

//REGISTER

/*

import 'dart:convert';
import 'package:http/http.dart' as http;

class BackendService {
  static const String apiUrl = 'http://your-laravel-api-url';

  Future<bool> registerUser({
    required String username,
    required String email,
    required String firstName,
    required String lastName,
    required String contactNumber,
    required String password,
    required String imagePath,
  }) async {
    final url = Uri.parse('$apiUrl/register/store');

    try {
      final response = await http.post(
        url,
        body: {
          'user_name': username,
          'email': email,
          'first_name': firstName,
          'last_name': lastName,
          'contact_number': contactNumber,
          'password': password,
        },
      );

      if (response.statusCode == 200) {
        // Registration successful
        return true;
      } else {
        // Registration failed
        print('Registration failed. Status code: ${response.statusCode}');
        return false;
      }
    } catch (e) {
      // Error occurred during registration
      print('Error occurred during registration: $e');
      return false;
    }
  }
}

*/

//LOGIN
/*class BackendService {
  static const String apiUrl = 'http://your-laravel-api-url';

  Future<bool> loginUser({
    required String username,
    required String password,
  }) async {
    final url = Uri.parse('$apiUrl/login/store');

    try {
      final response = await http.post(
        url,
        body: {
          'user_name': username,
          'password': password,
        },
      );

      if (response.statusCode == 200) {
        // Login successful
        return true;
      } else {
        // Login failed
        print('Login failed. Status code: ${response.statusCode}');
        return false;
      }
    } catch (e) {
      // Error occurred during login
      print('Error occurred during login: $e');
      return false;
    }
  }
}
 */

//VERIFICATION
/*Future<void> mobileStore() async {
  var url = Uri.parse('your_api_endpoint_here');

  var headers = {
    'Content-Type': 'application/json',
  };

  var request = {
    'user_id': 'your_user_id_value',
    'family_member': 'your_family_member_value',
    'house_no': 'your_house_no_value',
    'manual_visit_option': 'your_manual_visit_option_value'
  };

  var response = await http.post(
    url,
    headers: headers,
    body: json.encode(request),
  );

  if (response.statusCode == 200) {
    // Success response
    print('Request succeeded');
  } else {
    // Error response
    print('Request failed with status: ${response.statusCode}');
  }
} */
//FETCH THE ANNOUNMCEMENT MOBILE
/*
import 'package:http/http.dart' as http;
import 'dart:convert';

Future<List<dynamic>> fetchAnnouncementsByRole(int role) async {
  final response = await http.get(Uri.parse('http://your-api-endpoint/announcements?role=$role'));
  
  if (response.statusCode == 200) {
    // Decode the response JSON
    final data = jsonDecode(response.body);
    return data;
  } else {
    throw Exception('Failed to fetch announcements');
  }
}


*/

//DISPLAY THE ANNOUNCEMENT

/*
void getAnnouncements(int role) async {
  try {
    List<dynamic> announcements = await fetchAnnouncementsByRole(role);

    // Process the fetched announcements
    // ...
  } catch (e) {
    // Handle error
  }
}
*/
//ALWAYS PUT XCRF IN YOUR REQUEST 
//TOKEN IS FOUND IN WEB ROUTES XCRF
/*
 
import 'package:http/http.dart' as http;

String csrfToken = 'your-csrf-token'; // Replace with your actual CSRF token

Future<http.Response> makeApiRequest() async {
  final response = await http.get(
    Uri.parse('http://your-api-endpoint/your-api-path'),
    headers: {'X-XSRF-TOKEN': csrfToken},
  );

  return response;
}

 */