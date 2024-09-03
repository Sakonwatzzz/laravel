<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // แสดงไฟล์ทั้งหมด
    public function index()
    {
        $files = File::all();
        return view('home', compact('files')); // ส่งไฟล์ทั้งหมดไปยังวิว
    }

    // แสดงฟอร์มอัปโหลดไฟล์
    public function create()
    {
        return view('form');
    }

    // บันทึกไฟล์ที่อัปโหลด
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'file' => 'required|file|max:30048|mimetypes:text/plain,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip', // ตรวจสอบการอัปโหลดไฟล์
        ]);

        // บันทึกไฟล์ลงในโฟลเดอร์ "uploads"
        $filePath = $request->file('file')->store('uploads');

        $file = new File();
        $file->file_name = $request->file('file')->getClientOriginalName();
        $file->file_path = $filePath;
        $file->mime_type = $request->file('file')->getMimeType();
        $file->file_size = $request->file('file')->getSize();
        $file->save();

        return redirect()->route('files.index')->with('success', 'อัปโหลดไฟล์สำเร็จ');
    }

    // ลบไฟล์
    public function destroy(File $file)
    {
        Storage::delete($file->file_path);
        $file->delete();

        return redirect()->route('files.index')->with('success', 'ลบไฟล์สำเร็จ');
    }
}
