<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (! $request->user()?->isActive()) {
            abort(403, 'Tu usuario está inactivo.');
        }

        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
