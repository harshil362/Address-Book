<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        if (!$user->hasRole('Super Admin')) {
            abort(403, 'Only Super Admin can access this page.');
        }

        return $next($request);
    }
}