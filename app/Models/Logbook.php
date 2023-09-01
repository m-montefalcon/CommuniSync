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
        'contact_number',
        'visit_date'



    ];
   
}
