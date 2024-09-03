<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // กำหนดข้อมูลที่สามารถแก้ไขได้
    protected $fillable = [
        'image_name',
        'image_path',
        'mime_type',
        'image_size',
    ];
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
