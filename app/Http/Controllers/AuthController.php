<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Closure;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function registerPost(Request $request)
    {
        $user = new User();

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return back()->with('success', 'Register successfully');
        } catch (QueryException $e) {
            // ตรวจสอบข้อผิดพลาดที่เกิดขึ้นหากอีเมลซ้ำกัน
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'อีเมลนี้มีคนใช้แล้ว.');
            }
            return back()->with('error', 'An error occurred while registering.');
        }
    }

    public function login()
    {

        return view('login');
    }

    public function handle($request, Closure $next, $Id)
    {
        // ตรวจสอบว่า session ของผู้ใช้ที่ระบุไว้มีอยู่หรือไม่
        if (!session()->has('auth_user_' . $Id)) {
            return redirect('/login');
        }

        // จำลองการเข้าสู่ระบบของผู้ใช้ใน session
        Auth::loginUsingId($Id);

        return $next($request);
    }


    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลที่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ดึงข้อมูลผู้ใช้หลังจากเข้าสู่ระบบสำเร็จ
            $user = Auth::user();
            // เก็บข้อมูลลงใน session ด้วย Custom Key
            session(['auth_user_' . $user->id => (array) $user]);
            return redirect()->intended('/home');
        }
        return redirect()->back()->withErrors(['error' => 'ข้อมูลประจำตัวไม่ถูกต้อง']);
    }

    public function logout(Request $userId)
    {
        // ลบ session ที่เกี่ยวข้องกับผู้ใช้
        session()->forget('auth_user_' . $userId);

        // ทำการ Logout จากระบบ
        Auth::logout();

        return redirect('/login');
    }
}
