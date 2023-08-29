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
    
}
