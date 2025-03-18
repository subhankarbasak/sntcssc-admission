<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->is_admin) { // Assuming is_admin column exists
            return redirect('home')->with('error', 'Unauthorized access');
        }
        return $next($request);
    }
}