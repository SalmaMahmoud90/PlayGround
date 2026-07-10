<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        "code",
        "type",
        "value",
        "expiry_date",
        "usage_limit",
        "used"
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}