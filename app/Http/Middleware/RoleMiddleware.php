<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Admin and Rois are super users (Rois is Read-Only, enforced by other middleware/UI)
        if ($user->role === 'admin' || $user->role === 'rois') {
            return $next($request);
        }
        
        // Check if user's role matches any of the allowed roles
        if (!in_array($user->role, $roles)) {
            // Redirect to user's appropriate dashboard instead of showing 403
            return match($user->role) {
                'pendidikan' => redirect()->route('pendidikan.dashboard'),
                'sekretaris' => redirect()->route('sekretaris.dashboard'),
                'bendahara' => redirect()->route('bendahara.dashboard'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
