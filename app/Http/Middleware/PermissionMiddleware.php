<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        // User must be logged in
        if (!$user) {
            abort(401);
        }

        // Super Admin has full bypass access
        if ($user->hasRole('Super Admin') || strtolower($user->email) === 'superadmin@admin.com') {
            return $next($request);
        }

        // Super Admin and Admin can manage role assignments & permissions
        if (str_starts_with($permission, 'role_assignment.') && $user->hasRole('Admin')) {
            return $next($request);
        }

        // Check permission
        if (!$user->hasPermission($permission)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}