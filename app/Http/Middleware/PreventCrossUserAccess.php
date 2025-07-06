<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventCrossUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        // If trying to access customer routes
        if ($userType === 'customer') {
            // Redirect authors to their dashboard
            if (Auth::guard('author')->check()) {
                return redirect()->route('author.dashboard')->with('error', 'Access denied. Authors cannot access customer pages.');
            }
        }

        // If trying to access author routes
        if ($userType === 'author') {
            // Redirect customers to their dashboard
            if (Auth::guard('customer')->check()) {
                return redirect()->route('customer.dashboard')->with('error', 'Access denied. Customers cannot access author pages.');
            }
        }

        return $next($request);
    }
}
