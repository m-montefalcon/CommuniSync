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
        'blocked_reason',
        'blocked_status',
        'blocked_status_response_description'
    ];
    
    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopeVisitorBlocked($query, $visitor)
    {
        return $query->where(function ($query) use ($visitor) {
            $query->where('user_name', $visitor->user_name)
                ->orWhere('contact_number', $visitor->contact_number)
                ->orWhere(function ($query) use ($visitor) {
                    $query->where('first_name', $visitor->first_name)
                        ->where('last_name', $visitor->last_name);
                });
        });
    }
    public function scopeMemberBlock($query, $visitMembers)
    {
        $firstNames = [];
        $lastNames = [];
    
        foreach ($visitMembers as $member) {
            // Split the member name into first and last names
            $nameParts = explode(' ', $member);
    
            // Combine the first names except the last name
            $firstName = implode(' ', array_slice($nameParts, 0, -1));
            $firstNames[] = $firstName;
    
            // Get the last name
            $lastName = end($nameParts);
            $lastNames[] = $lastName;
        }
    
        // Ensure that both arrays have elements
        if (!empty($firstNames) && !empty($lastNames)) {
            // Use a closure to ensure that both conditions must be met
            $query->where(function ($query) use ($firstNames, $lastNames) {
                $query->whereIn('first_name', $firstNames)
                      ->whereIn('last_name', $lastNames);
            });
        }
    
        return $query->exists();
    }
    
    
    
    

}
