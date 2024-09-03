<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // แสดงรูปภาพทั้งหมด
    public function index()
    {
        $images = Image::all();
        return view('home', compact('images')); // ส่งรูปภาพทั้งหมดไปยังวิว
    }

    // แสดงฟอร์มอัปโหลดรูปภาพ
    public function create()
    {
        return view('form');
    }

    // บันทึกรูปภาพที่อัปโหลด
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'image' => 'required|image|max:30048', // ตรวจสอบการอัปโหลดรูปภาพ
        ]);

        $imagePath = $request->file('image')->store('images');

        $image = new Image();
        $image->image_name = $request->file('image')->getClientOriginalName();
        $image->image_path = $imagePath;
        $image->mime_type = $request->file('image')->getMimeType();
        $image->image_size = $request->file('image')->getSize();
        $image->save();

        return redirect()->route('images.index')->with('success', 'อัปโหลดรูปภาพสำเร็จ');
    }

    public function show($id)
    {
        $image = Image::find($id);
        return view('image.show', compact('image'));
    }
    // ลบรูปภาพ
    public function destroy(Image $image)
    {
        Storage::delete($image->image_path);
        $image->delete();

        return redirect()->route('images.index')->with('success', 'ลบรูปภาพสำเร็จ');
    }
}
