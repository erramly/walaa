<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('owner/*')) {
                return route('owner.login'); // اسم route تسجيل الدخول الخاص بالمالك
            } elseif ($request->is('admin/*')) {
                return route('admin.login'); // اسم route تسجيل الدخول الخاص بالادمن
            } else {
                return route('customer.login'); // للمستخدم العادي
            }
        }
    }
}
