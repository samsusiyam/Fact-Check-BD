<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Enforce pure English locale for all Filament admin panel requests
        app()->setLocale('en');

        return $next($request);
    }
}
