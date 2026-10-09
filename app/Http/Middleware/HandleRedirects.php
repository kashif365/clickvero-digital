<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    /**
     * Checks the current path against the cached active-redirects map and short-circuits
     * with a redirect response before the router resolves a matching application route.
     * A single cache read per request — no per-request database query.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $path = Redirect::normalizePath($request->getPathInfo());
        $entry = Redirect::activeMap()[$path] ?? null;

        if ($entry === null) {
            return $next($request);
        }

        $destination = $entry['destination'];
        $query = $request->getQueryString();

        if ($query) {
            $destination .= (str_contains($destination, '?') ? '&' : '?').$query;
        }

        return redirect($destination, $entry['type']);
    }
}
