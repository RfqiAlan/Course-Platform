<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
        if (! auth()->check()) {
            return redirect()->route('login');
        }

       
        $userRole = strtolower(auth()->user()->role);

        $allowedRoles = collect($roles)
            ->flatMap(function ($item) {
               
                return explode(',', (string) $item);
            })
            ->map(function ($role) {
                return strtolower(trim($role));
            })
            ->filter()       
            ->unique()
            ->values()
            ->toArray();

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
