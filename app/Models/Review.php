<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'play_ground_id', 'booking_id', 'comment', 'rating'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playground()
    {
        return $this->belongsTo(Playground::class, 'play_ground_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}