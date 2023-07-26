<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlAccess extends Model
{
   

    protected $fillable = [
        'visitor_id',
        'homeowner_id',
        'admin_id',
        'personnel_id',
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
}
