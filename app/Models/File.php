<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // กำหนดข้อมูลที่สามารถแก้ไขได้
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
