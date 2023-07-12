<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'announcement_title',
        'announcement_description',
        'announcement_photo',
        'announcement_date',
        'role'
    ];
}
