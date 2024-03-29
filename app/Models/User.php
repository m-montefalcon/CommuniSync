<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'first_name',
        'last_name',
        'contact_number',
        'block_no',
        'lot_no',
        'family_member',
        'email_verified_at',
        'manual_visit_option',
        'photo',
        'role',
        'email',
        'password',
        'fcm_token'
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //IMPLEMENTING RELATIONSHIP TO ANNOUNCEMENT DATABASE
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    public function scopeSearch($query, $searchTerm)
    {
        $searchTerms = explode(' ', $searchTerm);

        return $query->where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->where('first_name', 'like', '%' . $term . '%')
                    ->orWhere('last_name', 'like', '%' . $term . '%');
            }
        });
    }

    public function scopeCheckMvo($query, $firstName, $lastName, $role){
        return $query->where('first_name', $firstName)
                     ->where('last_name', $lastName)
                     ->where('role', $role)
                     ->where('manual_visit_option', 1);
    }
    public function scopeCheckMvoPartial($query, $fullName, $role) {
        $nameParts = explode(' ', $fullName);

        $lastName = array_pop($nameParts);
        $firstName = implode(' ', $nameParts);

        return $query->where(function ($query) use ($firstName, $lastName) {
            $query->where('first_name', 'LIKE', '%' . $firstName . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $lastName . '%');
        })->where('role', $role)
          ->where('manual_visit_option', 1);
    }
    public function scopeChecksRoleWithSearch($query, $search, $role) {
        // Split the search string into an array of names
        $names = explode(' ', $search);
    
        return $query->select('*')
            ->where(function ($query) use ($names) {
                foreach ($names as $name) {
                    $searchLower = strtolower($name);
    
                    $query->orWhere('first_name', 'like', '%' . $name . '%')
                        ->orWhere('last_name', 'like', '%' . $name . '%')
                        ->orWhere(function ($query) use ($searchLower) {
                            // Use LIKE for case-insensitive search
                            $query->whereRaw('LOWER(`family_member`) like ?', ['%' . $searchLower . '%']);
                        });
                }
            })
            ->where('role', $role)
            ->orderByRaw('
                CASE
                    WHEN first_name LIKE ? THEN 1
                    WHEN last_name LIKE ? THEN 2
                    WHEN family_member LIKE ? THEN 3
                    ELSE 4
                END
            ', ['%' . $names[0] . '%', '%' . $names[0] . '%', '%' . $names[0] . '%'])
            ->get();
    }
    
    
    public function scopeChecksRoleWithUsername($query, $username, $role){
        return $query->where('user_name', $username)
                     ->where('role', $role)
                     ->first();

    }
    
    
    public function scopeChecksRole($query, $role){
        return $query->where('role', $role)
                     ->orderBy('first_name')
                     ->orderBy('last_name');
    }
    

}

