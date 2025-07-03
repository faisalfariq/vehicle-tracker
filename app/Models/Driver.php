<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';
    protected $fillable = [
        'name', 
        'license_number', 
        'phone', 
        'region_id', 
        'is_active'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
