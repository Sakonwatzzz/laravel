<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notes = Note::where('user_id', $user->id)->get();
        return view('home', compact('notes'));
    }

    public function home()
    {
        return $this->index();
    }



    public function create()
    {
        return view('form');
    }
    public function edit(Note $note)
    {
        // ดึงความสัมพันธ์กับไฟล์และรูปภาพพร้อมกับ Note
        $files = $note->files;
        $images = $note->images;
        return view('edit', compact('note', 'files', 'images'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|max:30048|mimetypes:text/plain,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|max:30048',
        ]);

        $filePath = null;
        $imagePath = null;

        // สร้าง Note ใหม่
        $note = Note::create([
            'email' => $request->email,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        // จัดการการบันทึกไฟล์ลงในตาราง files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('uploads/files', 'public');
                $note->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
        // จัดการการบันทึกหลายรูปภาพลงในตาราง images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('uploads/images', 'public');
                $note->images()->create([
                    'image_name' => $image->getClientOriginalName(),
                    'image_path' => $imagePath,
                    'mime_type' => $image->getMimeType(),
                    'image_size' => $image->getSize(),
                ]);
            }
        }


        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|max:30048|mimetypes:text/plain,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|max:30048',
        ]);

        // อัปเดตข้อมูล Note
        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // อัปเดตหรือเพิ่มไฟล์ใหม่
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $filePath = $file->store('uploads/files', 'public');
                $note->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // อัปเดตหรือเพิ่มรูปภาพใหม่
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePath = $image->store('uploads/images', 'public');
                $note->images()->create([
                    'image_name' => $image->getClientOriginalName(),
                    'image_path' => $imagePath,
                    'mime_type' => $image->getMimeType(),
                    'image_size' => $image->getSize(),
                ]);
            }
        }

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function deleteFiles(Request $request, Note $note)
    {
        // ลบไฟล์ที่เลือก
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileId) {
                $file = $note->files()->find($fileId);
                if ($file) {
                    Storage::delete('public/' . $file->file_path); // ลบไฟล์จาก storage
                    $file->delete(); // ลบข้อมูลจากฐานข้อมูล
                }
            }
        }

        // ลบรูปภาพที่เลือก
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $note->images()->find($imageId);
                if ($image) {
                    Storage::delete('public/' . $image->image_path); // ลบรูปภาพจาก storage
                    $image->delete(); // ลบข้อมูลจากฐานข้อมูล
                }
            }
        }
        return redirect()->route('notes.edit', $note->id)->with('success', 'Selected files and images deleted successfully.');
    }

    public function destroy(Note $note)
    {

        try {
            $note->delete(); // ลบ Note
            return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Note deletion error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the note. Please try again.');
        }
    }
}
