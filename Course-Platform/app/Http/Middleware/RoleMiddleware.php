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
     * Contoh pemakaian di route:
     *  ->middleware('role:teacher')
     *  ->middleware('role:teacher,admin')
     *  ->middleware('role:admin,teacher,super')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login, paksa ke halaman login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Role user dari database (misal: 'admin', 'teacher', 'student')
        $userRole = strtolower(auth()->user()->role);

        /**
         * Laravel akan mengirim parameter middleware seperti ini:
         *  'role:teacher,admin'  => $roles = ['teacher', 'admin']
         *
         * Tapi untuk jaga-jaga, kita:
         *  - explode lagi jika ada koma di dalam parameter
         *  - trim spasi
         *  - lowercase semua
         *  - hilangkan yang kosong
         */
        $allowedRoles = collect($roles)
            ->flatMap(function ($item) {
                // pisah lagi kalau ada koma dalam satu param
                return explode(',', (string) $item);
            })
            ->map(function ($role) {
                return strtolower(trim($role));
            })
            ->filter()       // buang string kosong
            ->unique()
            ->values()
            ->toArray();

        // Jika role user tidak ada di daftar allowedRoles → 403
        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
