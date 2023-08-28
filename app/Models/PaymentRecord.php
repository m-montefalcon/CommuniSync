<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'homeowner_id',
        'payment_date',
        'payment_amount',
        'transaction_number',
        'notes'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }
}
