<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlAccess;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ControlAccessController extends Controller
{
    //SEARCH THE HOMEOWNER ONLY
    public function searchMobile(Request $request)
    {
        try {
            $username = $request->input('username');
            $users = User::where('user_name', 'LIKE', "%{$username}%")
                         ->where('role', 2)
                         ->get();

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error'], 500);
        }
    }


    //REQUEST ACCESS VISITOR ONLY
    public function requestMobile(Request $request){
       
        $validatedData = $request->validate([
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'destination_person' => ['required'],
            'visit_members' => ['nullable', 'array'],
        ]);
    
        $validatedData['visit_status'] = 1;
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $validatedData['visit_members'] = json_encode($validatedData['visit_members']);
    
        ControlAccess::create($validatedData);
    
        return response()->json(['request success' => true], 200);
       
    }

    //HOMEOWNER ACCEPT TO VISITOR
    public function acceptMobile(Request $request, ControlAccess $id){
        $validatedData = $request->validate([
            'visit_status' => ['required', 'integer']
        ]);
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        // @dd($validatedData);
        $id->update($validatedData);

        return response()->json(['accepted' => true], 200);
    }


    //ADMIN VALIDATES THE REQUEST
    public function validated(Request $request, ControlAccess $id){
        
        $validatedData = $request->validate([
            'visit_status' => ['required', 'integer']
        ]);
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $id->update($validatedData);


         // Create data array to encode in QR code
        $dataToEncode = [
            'ID' => $id->id,
            'Visitor ID' => $id->visitor_id,
            'Homeowner ID' => $id->homeowner_id,
            'Admin ID' => $id->admin_id,
            'Date' => Carbon::now()->toDateString(),
            'Time' =>Carbon::now()->toTimeString(),
            'Destination' => $id->destination_person,
            'Visit Members' => $id->visit_members,
            'Visit Status' => $id->visit_status
        ];

       // Encode data array as JSON
        $jsonToEncode = json_encode($dataToEncode);

        $qrCode = QrCode::encoding('UTF-8')->size(300)->generate($jsonToEncode);
        $id->qr_code = $qrCode;
        $id->save();
        return response()->json(['qr_code' => $qrCode],  200);
    }
    public function recordedMobile(Request $request, ControlAccess $id){
        $validatedData = $request->validate([
            'visit_status' => ['required', 'integer']
        ]);
        $validatedData['date'] = Carbon::now()->toDateString();
        $validatedData['time'] = Carbon::now()->toTimeString();
        $id->update($validatedData);

        return response()->json(['scanned' => true], 200);


    }


    public function test(){
        $qrcodes  = ControlAccess::all('qr_code');

        return view('qrcode', compact('qrcodes'));
    }

}
