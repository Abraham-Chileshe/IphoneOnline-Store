<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        // Default currency if not set
        if (!session()->has('currency')) {
            session()->put('currency', app()->getLocale() == 'ru' ? 'RUB' : 'USD');
        }

        return $next($request);
    }
}
