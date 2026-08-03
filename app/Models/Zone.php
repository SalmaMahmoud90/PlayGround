<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'is_active'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function playgrounds()
    {
        return $this->hasMany(Playground::class);
    }
}