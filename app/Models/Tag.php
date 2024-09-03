<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['name'];  // เพิ่มฟิลด์ name ลงใน fillable property
    // public function notes()
    // {
    //     return $this->belongsToMany(Note::class);
    // }
    // public function showForm()
    // {
    //     $tags = Tag::all(); // ดึงข้อมูล tags ทั้งหมดจากฐานข้อมูล
    //     return view('form', compact('tags'));
    // }
}
