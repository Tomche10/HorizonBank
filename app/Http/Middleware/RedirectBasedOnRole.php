<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            $role = Auth::user()->role; // Assuming your User model has a 'role' field
            $currentRoute = $request->route()->getName();

            // Define the role-to-route mapping
            $roleRoutes = [
                'admin' => 'admin.dashboard',
                'banker' => 'banker.dashboard',
                'user' => 'dashboard',
            ];

            // If the user is not on their assigned dashboard route, redirect them
            if (isset($roleRoutes[$role]) && $currentRoute !== $roleRoutes[$role]) {
                return redirect()->route($roleRoutes[$role]);
            }
        }

        return $next($request);
    }
}
