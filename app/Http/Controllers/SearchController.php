<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Note;

class SearchController extends Controller
{
    // public function search(Request $request)
    // {
        // $query = $request->input('query');
        // $userEmail = Auth::user()->email;

        // $notes = Note::where('user_id', Auth::id())->get();

        // // ค้นหาข้อมูลตามคำค้นหาและอีเมลของผู้ใช้ที่ล็อกอินอยู่
        // $results = Note::where('email', $userEmail)
        //     ->where(function ($q) use ($query) {
        //         $q->where('title', 'LIKE', '%' . $query . '%')  // แทนที่ 'field1' ด้วยชื่อฟิลด์ที่ต้องการค้นหา
        //             ->orWhere('content', 'LIKE', '%' . $query . '%'); // แทนที่ 'field2' ด้วยฟิลด์อื่นๆ ที่ต้องการค้นหา
        //     })
        //     ->get();

        // return view('search', compact('results'));
    //}
}
