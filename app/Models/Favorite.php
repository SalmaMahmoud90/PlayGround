<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ["play_ground_id", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playground()
    {
        return $this->belongsTo(Playground::class, 'play_ground_id');
    }
}