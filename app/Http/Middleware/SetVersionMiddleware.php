<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetVersionMiddleware
{
    public function handle(Request $request, Closure $next, $version)
    {
        $request->session()->put('version', $version);

        return $next($request);
    }
}
