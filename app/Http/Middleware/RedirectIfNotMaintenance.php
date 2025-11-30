<?php

namespace App\Http\Middleware;

use App\Models\General;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $general = cache()->remember('general_settings', 60, fn() => General::first());

        // If maintenance is NOT active, redirect to homepage
        if (!$general || !$general->maintenance) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
