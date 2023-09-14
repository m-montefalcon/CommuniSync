<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Announcement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'admin_id',
        'announcement_title',
        'announcement_description',
        'announcement_photo',
        'announcement_date',
        'role'
    ];
    //IMPLEMENTING RELATIONSHIP TO THE USER DATABASE
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id',);
    }

    public function scopeWithRole($query, $role){
        return $query->whereJsonContains('role', [$role]);
    }
    
}
