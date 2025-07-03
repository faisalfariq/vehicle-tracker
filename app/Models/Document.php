<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = [
        'booking_id', 
        'file_path'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
