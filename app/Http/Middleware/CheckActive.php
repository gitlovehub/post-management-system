<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Kiểm tra xem người dùng có hoạt động không
            if ($user->is_active == 0) {
                // Đăng xuất người dùng và chuyển hướng về trang đăng nhập
                Auth::logout();
                return redirect('login')->with('msg', 'You are banned! 😣');
            }
        }
        return $next($request);
    }
}
