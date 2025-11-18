<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Pemakaian di route:
     * ->middleware('role:teacher')
     * atau
     * ->middleware('role:teacher,admin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // role user dari database
        $userRole = strtolower(auth()->user()->role);

        // normalisasi semua parameter role ke lowercase
        $roles = array_map('strtolower', $roles);

        if (! in_array($userRole, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
