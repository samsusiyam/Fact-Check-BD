<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Redirect;

class HandleRedirectsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/' . ltrim($request->path(), '/');

        // Check if there is an active redirect matching this path
        $redirect = Redirect::where('source_path', $path)
            ->where('is_active', true)
            ->first();

        if ($redirect) {
            return redirect($redirect->target_url, $redirect->status_code);
        }

        return $next($request);
    }
}
