<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    protected $table = 'service_logs';
    protected $fillable = [
        'vehicle_id', 
        'service_date', 
        'description', 
        'km', 
        'cost'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}