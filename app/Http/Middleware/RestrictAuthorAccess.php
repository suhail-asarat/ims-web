<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictAuthorAccess
{
    /**
     * Handle an incoming request.
     * Redirects authors to their dashboard if they try to access non-author routes
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is logged in as author
        if (Auth::guard('author')->check()) {
            // Allow access to author routes, login/logout, and admin routes
            $allowedPaths = [
                'author-dashboard',
                'author/profile',
                'my-manuscripts*',
                'login',
                'logout',
                'admin/*'
            ];

            $currentPath = $request->path();

            // Check if current path is allowed
            foreach ($allowedPaths as $pattern) {
                if (fnmatch($pattern, $currentPath)) {
                    return $next($request);
                }
            }

            // If trying to access root or other non-author routes, redirect to author dashboard
            return redirect()->route('author.dashboard')->with('info', 'Authors can only access the author portal.');
        }

        return $next($request);
    }
}
