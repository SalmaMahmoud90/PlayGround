<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'phone', 'is_verified'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playgrounds()
    {
        return $this->hasMany(Playground::class);
    }
}