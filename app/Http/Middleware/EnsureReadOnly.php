<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureReadOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'rois') {
            if (!$request->isMethodSafe()) { // safe methods are GET and HEAD
                if ($request->expectsJson()) {
                     return response()->json(['message' => 'Action unauthorized for Rois (Read Only).'], 403);
                }
                return back()->with('error', 'Akun Rois hanya memiliki akses Lihat Data (Read Only).');
            }
        }

        return $next($request);
    }
}
