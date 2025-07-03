<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Region extends Model
{
    protected $table = 'regions';
    protected $fillable = [
        'name', 
        'type', 
        'address'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
