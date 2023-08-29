<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function storeMobile(Request $request){
        $validatedData = $request->validate([
            'homeowner_id' => ['required', 'integer'],
            'complaint_title' => ['required'],
            'complaint_desc' => ['required'],
            'complaint_photo' => ['nullable']
        ]);
        $validatedData['admin_id'] = Auth::id();

        $validatedData['complaint_date'] = now()->toDateString();
        $validatedData['complaint_status'] = 1;
    
        Complaint::create($validatedData);
        return response()->json(['submitted complaint'=> true, 'data' => $validatedData], 200);
    }


    public function update(Request $request, Complaint $id)
    {
        $validatedData = $request->validate([
            'complaint_updates' => ['required'],
        ]);
    
        // Retrieve the complaint record and check if it exists
        if (!$id) {
            return response()->json(['error' => 'Complaint not found'], 404);
        }
    
        // Decode the existing complaint updates or initialize an empty array
        $existingUpdates = json_decode($id->complaint_updates, true) ?? [];
    
        // Append the new update to the existing updates array
        $existingUpdates[] = [
            'update' => $validatedData['complaint_updates'],
            'date' => now()->toDateString(),
        ];
    
        // Encode the updated complaint updates to JSON
        $encodedUpdates = json_encode($existingUpdates);
    
        // Update the complaint record with the validated data and encoded updates
        $id->update([
            'complaint_updates' => $encodedUpdates,
            'complaint_status' => 2,
            'complaint_date' => now()->toDateString()
        ]);
    
        return response()->json(['updated complaint' => true, $id], 200);
    }
    
  
    public function close(Request $request, Complaint $id)
    {
        $validatedData = $request->validate([
            'complaint_updates' => ['required'],
        ]);
    
        // Retrieve the complaint record and check if it exists
        if (!$id) {
            return response()->json(['error' => 'Complaint not found'], 404);
        }
    
        // Decode the existing complaint updates or initialize an empty array
        $existingUpdates = json_decode($id->complaint_updates, true) ?? [];
    
        // Add the new update to the existing updates array
        $existingUpdates[] = [
            'resolution' => $validatedData['complaint_updates'],
            'date' => now()->toDateString(),
        ];
    
        // Encode the updated complaint updates to JSON
        $encodedUpdates = json_encode($existingUpdates);
    
        // Validate the complaint status and date
        $validatedData['complaint_status'] = 3;
        $validatedData['complaint_date'] = now()->toDateString();
    
        // Update the complaint record with the validated data and encoded updates
        $id->update([
            'complaint_updates' => $encodedUpdates,
            'complaint_status' => $validatedData['complaint_status'],
            'complaint_date' => $validatedData['complaint_date']
        ]);
    
        return response()->json(['updated complaint' => true, $id], 200);
    }
    
    
    public function fetch(){
        $fetchALlComplaints =  Complaint::with('homeowner')->with('admin')->where('complaint_status', [1,2])->get();
        return response()->json(['data' => $fetchALlComplaints,], 200);

    }
}
