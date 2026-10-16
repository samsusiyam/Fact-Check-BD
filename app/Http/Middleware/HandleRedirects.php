<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Redirect;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = "/" . ltrim($request->path(), "/");

        $redirect = Redirect::where("source_path", $path)
            ->where("is_active", true)
            ->first();

        if ($redirect) {
            $redirect->increment("hits");
            return redirect($redirect->target_url, $redirect->status_code);
        }

        return $next($request);
    }
}
