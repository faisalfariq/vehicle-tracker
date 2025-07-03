<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    protected $table = 'fuel_logs';
    protected $fillable = [
        'vehicle_id', 
        'booking_id', 
        'date', 
        'fuel_amount', 
        'fuel_cost', 
        'km_before', 
        'km_after'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}