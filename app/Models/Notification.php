<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'body', 'role', 'recipient_id', 'is_hovered'];
    
    public function recipientId()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
