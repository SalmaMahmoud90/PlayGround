<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'play_ground_id', 'booking_id', 'comment'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function playGround(){
        return $this->belongsTo(PlayGround::class);
    }
    public function booking(){
        return $this->belongsTo(Booking::class);
    }
}
