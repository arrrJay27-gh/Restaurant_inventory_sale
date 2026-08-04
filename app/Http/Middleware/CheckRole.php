<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();
        $userRole = strtolower(str_replace([' ', '_'], '', $user->role ?? ''));

        $allowedRoles = array_map(function ($role) {
            return strtolower(str_replace([' ', '_'], '', $role));
        }, $roles);

        // Permitted access
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // Kung Customer ang nagtangkang pumasok sa Admin Dashboard -> Ibalik sa POS
        if ($userRole === 'customer') {
            return redirect('/pos')->with('error', 'Unauthorized access.');
        }

        // Default fallback para maiwasan ang redirect loop
        return abort(403, 'Unauthorized action.');
    }
}