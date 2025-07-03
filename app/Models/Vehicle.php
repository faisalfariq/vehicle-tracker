<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'name', 
        'plate_number', 
        'type_id', 
        'is_rented', 
        'fuel_type', 
        'region_id', 
        'is_available'
    ];

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function serviceLogs()
    {
        return $this->hasMany(ServiceLog::class);
    }
}
