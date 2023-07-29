<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlockList extends Model
{
    use HasFactory;

    protected $fillable = [
        'homeowner_id',
        'admin_id',
        'user_name',
        'first_name',
        'last_name',
        'contact_number',
        'blocked_date',
        'block_reason',
        'block_status',
        'block_status_response_description'
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
