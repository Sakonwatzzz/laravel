<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $userEmail = Auth::user()->email;

        // $notes = Note::where('user_id', Auth::id())->get();

        // ค้นหาข้อมูลตามคำค้นหาและอีเมลของผู้ใช้ที่ล็อกอินอยู่
        $notes = Note::where('email', $userEmail)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')  // แทนที่ 'field1' ด้วยชื่อฟิลด์ที่ต้องการค้นหา
                    ->orWhere('content', 'LIKE', '%' . $query . '%') // แทนที่ 'field2' ด้วยฟิลด์อื่นๆ ที่ต้องการค้นหา
                    ->orWhere('created_at', 'LIKE', '%' . $query . '%');
            })
            ->get();

        return view('home', compact('notes'));
    }
    
}
