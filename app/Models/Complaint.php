<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'homeowner_id',
        'complaint_title',
        'complaint_desc',
        'complaint_updates',
        'complaint_date',
        'complaint_photo',
        'complaint_status'
    ];
    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function scopeStatus($query, $status1, $status2){
        return  $query->where('complaint_status', $status1)
                      ->orWhere('complaint_status', $status2);
    }

    public function scopeFetchAllComplaintsByHomeowner($query, $homeownerId){
        return $query ->where('homeowner_id', $homeownerId)
                      ->get();
    }
}
