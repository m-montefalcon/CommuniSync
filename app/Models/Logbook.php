<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'homeowner_id',
        'visitor_id',
        'personnel_id',
        'visit_members',
        'destination_person',
        'contact_number',
        'visit_date_in',
        'visit_time_in',
        'visit_date_out',
        'visit_time_out',
        'logbook_status'
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
