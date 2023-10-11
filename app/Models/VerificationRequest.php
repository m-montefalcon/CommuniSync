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
        'block_no',
        'lot_no',
        'family_member'
    ];
    public function scopeIfExist($query, $id){
        return $query->where('user_id', $id)
                     ->exists();

    }

    
}
