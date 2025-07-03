<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingApproval extends Model
{
    protected $table = 'booking_approvals';
    protected $fillable = [
        'booking_id', 
        'approver_id', 
        'level', 
        'status', 
        'note', 
        'approved_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
