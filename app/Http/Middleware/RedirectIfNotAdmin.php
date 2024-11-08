<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->user_type !== 'Admin' && Auth::user()->user_type !== 'Dean' && Auth::user()->user_type !== 'Program-Head') {
            return redirect()->route('faculty.dashboard');
        }
        return $next($request);
    }
}
