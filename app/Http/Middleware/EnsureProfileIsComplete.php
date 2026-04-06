<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isPersonnel()) {
            // Priority 1: Password must be changed first
            if (Auth::user()->password_must_change) {
                return $next($request);
            }

            // Priority 2: Profile must be completed
            if (!Auth::user()->personnelProfile) {
                $allowedRoutes = ['profile.complete', 'profile.store', 'logout'];
                
                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    return redirect()->route('profile.complete');
                }
            }
        }

        return $next($request);
    }
}
