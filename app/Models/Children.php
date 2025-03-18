<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    //

    protected $table= 'children';
    protected $fillable = [
        'name',
        'age',
        'month',
    ];  


    public function bookings()
    {
        // return $this->belongsToMany(Booking::class, 'booking_child');
                    // ->withPivot('booking_id'); // Optional: Add any extra columns from the pivot table
    }
}
