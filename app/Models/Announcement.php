<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Announcement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'created_by',
        'created_by_name',
        'announcement_title',
        'announcement_description',
        'announcement_photo',
        'announcement_date',
        'role'
    ];
    //IMPLEMENTING RELATIONSHIP TO THE USER DATABASE
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
