<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CatalogViewTypeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('view_type')) {
            session()->put('view_type', $request->get('view_type'));
        }

        return $next($request);
    }
}
