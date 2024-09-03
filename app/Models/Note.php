<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'email', 'title', 'content', 'user_id'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
