<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() && !$request->is('login', 'register', 'password/*')) {
            return redirect('/login');
        }

        return $next($request);
    }
}

