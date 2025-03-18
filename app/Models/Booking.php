<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    protected $table = 'bookings';


    protected $fillable = [
        'booking_no',
        'reservation_datetime',
        'street_address',
        'city',
        'state',
        'zip_code',
        'session_id',
        'user_id'
    ];



    
}
