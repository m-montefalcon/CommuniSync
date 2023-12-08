<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'homeowner_id',
        'visitor_id',
        'personnel_id',
        'visit_members',
        'destination_person',
        'contact_number',
        'visit_date_in',
        'visit_time_in',
        'visit_date_out',
        'visit_time_out',
        'logbook_status'
    ];
    
    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }

    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function personnel()
    {
        return $this->belongsTo(User::class, 'personnel_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerms = explode(' ', $searchTerm);
    
        return $query->where(function ($subQuery) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $subQuery->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(visit_members, '$[*]')) like ?", ['%' . $term . '%']);
            }
    
            $subQuery->orWhereHas('admin', function ($adminQuery) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $adminQuery->where('first_name', 'like', '%' . $term . '%')
                                ->orWhere('last_name', 'like', '%' . $term . '%');
                }
            })
            ->orWhereHas('homeowner', function ($homeownerQuery) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $homeownerQuery->where('first_name', 'like', '%' . $term . '%')
                                   ->orWhere('last_name', 'like', '%' . $term . '%');
                }
            })
            ->orWhereHas('visitor', function ($visitorQuery) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $visitorQuery->where('first_name', 'like', '%' . $term . '%')
                                   ->orWhere('last_name', 'like', '%' . $term . '%');
                }
            })
            ->orWhere('admin_id', 'like', '%' . $searchTerms[0] . '%')
            ->orWhere('homeowner_id', 'like', '%' . $searchTerms[0] . '%');
        });
    }
    
}
