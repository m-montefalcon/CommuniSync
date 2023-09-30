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

    public function scopeCheckMvo($query, $firstName, $lastName, $role){
        return $query->where('first_name', $firstName)
                     ->where('last_name', $lastName)
                     ->where('role', $role)
                     ->where('manual_visit_option', 1)
                     ->get();
    }
    public function scopeChecksRoleWithUsername($query, $username, $role){
        return $query->where('user_name', $username)
                     ->where('role', $role)
                     ->first();

    }
    public function scopeChecksRole($query, $role){
        return $query->where('role', $role)
                     ->get();
                     
    }

}

