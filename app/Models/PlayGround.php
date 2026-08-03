<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playground extends Model
{
    use HasFactory;

    protected $table = 'play_grounds';

    protected $fillable = [
        'location',
        'city',
        'type',
        'image',
        'hourPrice',
        'hourWork',
        'minHours',
        'maxHours',
        'is_active',
        'owner_id',
        'city_id',
        'zone_id',
        'name',
        'description',
        'price_per_hour',
        'min_booking_hours',
        'max_booking_hours',
        'opening_time',
        'closing_time',
        'location_url',
    ];

    // العلاقات
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'play_ground_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'play_ground_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'play_ground_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function images()
    {
        return $this->hasMany(PlaygroundImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(PlaygroundImage::class)->where('is_primary', true);
    }
}