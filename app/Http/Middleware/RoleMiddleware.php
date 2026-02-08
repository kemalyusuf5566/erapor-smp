<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (! $user || ! $user->peran) {
            abort(403, 'Tidak memiliki peran');
        }

        if ($user->peran->nama_peran !== $role) {
            abort(403, 'Tidak memiliki akses');
        }

        return $next($request);
    }
}
