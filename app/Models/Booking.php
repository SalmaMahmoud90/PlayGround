<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'start_date_time',
        'end_date_time',
        'status',
        'payment_method',
        'payment_status',
        'total_price',
        'cancelled_at',
        'play_ground_id', 
        'user_id', 
        'coupon_id'
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function playGround(){
        return $this->belongsTo(PlayGround::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }
}
