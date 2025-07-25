<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedByGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // توجيه المستخدم حسب نوعه مباشرة
                switch ($guard) {
                    case 'owner':
                        return redirect()->route('owner.dashboard');
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'customer':
                        return redirect()->route('customer.dashboard');
                    default:
                        return redirect('/'); // إذا guard غير معروف
                }
            }
        }

        return $next($request);
    }
}



// <?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

// class RedirectIfAuthenticatedByGuard
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next, ...$guards)
//     {
//         foreach ($guards as $guard) {
//             if (Auth::guard($guard)->check()) {
//                 // تأكد أننا لسنا في صفحة الـ dashboard مسبقًا
//                 if ($request->routeIs('owner.login') || $request->is('owner/login')) {
//                     // فقط إعادة توجيه إذا نحن في صفحة تسجيل الدخول وليس في dashboard
//                     switch ($guard) {
//                         case 'owner':
//                             return redirect()->route('owner.dashboard');
//                         case 'admin':
//                             return redirect()->route('admin.dashboard');
//                         case 'web':
//                             return redirect()->route('user.dashboard');
//                     }
//                 }
//             }
//         }

//         return $next($request);
//     }
// }