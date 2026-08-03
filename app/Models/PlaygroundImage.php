<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaygroundImage extends Model
{
    use HasFactory;

    protected $fillable = ['playground_id', 'image_path', 'is_primary'];

    public function playground()
    {
        return $this->belongsTo(Playground::class);
    }
}