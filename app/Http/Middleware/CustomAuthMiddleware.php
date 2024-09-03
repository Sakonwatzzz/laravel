<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  // สำหรับการใช้งาน Auth
use Illuminate\Support\Facades\Session;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $userId)
    {
        // ตรวจสอบว่า session ของผู้ใช้ที่ระบุไว้มีอยู่หรือไม่
        if (!Session::has('auth_user_' . $userId)) {
            return redirect('/login');
        }

        // จำลองการเข้าสู่ระบบของผู้ใช้ใน session
        Auth::loginUsingId($userId);

        return $next($request);
    }
}
