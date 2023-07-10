<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
        'user_name',
        'first_name',
        'last_name',
        'contact_number',
        'house_no',
        'family_member',
        'email_verified_at',
        'manual_visit_option',
        'photo',
        'role',
        'email',
        'password',
        
    ];
    
}
