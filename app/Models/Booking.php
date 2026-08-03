<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'play_ground_id',
        'user_id',
        'coupon_id',
        'start_date_time',
        'end_date_time',
        'status',
        'payment_method',
        'payment_status',
        'total_price',
        'cancelled_at',
    ];

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function playground()
    {
        return $this->belongsTo(Playground::class, 'play_ground_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}