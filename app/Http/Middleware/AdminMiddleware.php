<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Gate::denies('manage-items')) {
            return redirect('/')->withErrors('You are not allowed to access this page.');
        }

        return $next($request);
    }
}