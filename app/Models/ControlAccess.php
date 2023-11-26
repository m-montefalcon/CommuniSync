<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlAccess extends Model
{
   

    protected $fillable = [
        'visitor_id',
        'visitor_name',
        'homeowner_id',
        'homeowner_name',
        'admin_id',
        'admin_name',
        'personnel_id',
        'personnel_name',
        'date',
        'time',
        'destination_person',
        'visit_members',
        'visit_status',
        'qr_code'
    ];
    protected $casts = [
        'visit_members' => 'json',
    ];
    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }

    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function personnel()
    {
        return $this->belongsTo(User::class, 'personnel_id');
    }

    public function scopeFetchRequests($query, $id){
        return $query->where('homeowner_id', $id)
                     ->where('visit_status', 1)
                     ->orderByDesc('created_at') 
                     ->get();
    }
    

    public function scopeCheckQr($query, $id, $homeowner_id, $visitor_id){
        return $query -> where('id', $id)
                      -> where('homeowner_id', $homeowner_id)
                      ->where('visitor_id', $visitor_id)
                      ->first();

    }

    public function scopeGetAllValidatedRequest($query, $id)
    {
        return $query->where('visitor_id', $id)
            ->where(function ($query) {
                $query->where('visit_status', 4)
                    ->orWhere('visit_status', 6)
                    ->orWhereNotNull('qr_code'); // Add this condition
            })
            ->orderByDesc('created_at') // Replace 'your_column_name' with the actual column name
            ->get();
    }
    
    
    
}
