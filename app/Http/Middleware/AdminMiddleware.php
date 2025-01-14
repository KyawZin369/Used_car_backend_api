<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
