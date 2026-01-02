<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            \Log::warning('Unauthorized admin access attempt', [
                'ip' => $request->ip(),
                'user_id' => auth()->id(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);
            abort(403, 'Unauthorized access.');
        }

        // Log all admin actions for audit trail
        \Log::info('Admin access', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => $request->method() . ' ' . $request->path(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $next($request);
    }
}
