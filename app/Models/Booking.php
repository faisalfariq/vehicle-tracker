<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected  $table = 'bookings';
    protected $fillable = [
        'code', 
        'user_id', 
        'vehicle_id', 
        'driver_id', 
        'start_datetime', 
        'end_datetime', 
        'destination', 
        'reason', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvals()
    {
        return $this->hasMany(BookingApproval::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function bookingLogs()
    {
        return $this->hasMany(BookingLog::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}