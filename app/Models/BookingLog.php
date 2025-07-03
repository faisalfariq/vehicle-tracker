<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingLog extends Model
{
    protected $table = 'booking_logs';
    protected $fillable = [
        'booking_id',
        'event',
        'datetime',
        'odometer',
        'notes'
    ]; 


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}