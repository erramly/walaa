<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOwnerIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('owner')->user();

        // Make sure the user is associated with a restaurant
        if (!$user || !$user->restaurant) {
            // You can redirect to the login page or an error page
            return redirect()->route('owner.noActiveRestaurant');
        }

        // If the restaurant is not active, only allow access to the noActiveRestaurant page
        if (!$user->restaurant->is_active) {
            if (!$request->routeIs('owner.noActiveRestaurant')) {
                return redirect()->route('owner.noActiveRestaurant');
            }
            return $next($request);
        }

        // If the restaurant is active, do not allow staying on the noActiveRestaurant page
        if ($request->routeIs('owner.noActiveRestaurant')) {
            return redirect()->route('owner.dashboard');
        }

        return $next($request);
    }
}
