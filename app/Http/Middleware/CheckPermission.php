<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
       // Check if the user is logged in and has the required permission
        if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
            // Return 403 Forbidden response if permission is missing
            abort(403, 'Unauthorized action. You do not have the required permission.');
        }

        return $next($request);
    }
}
