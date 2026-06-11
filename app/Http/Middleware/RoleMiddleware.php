<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan user sudah login dan role-nya sesuai dengan yang diminta rute
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Jika melanggar, tampilkan error 403 (Forbidden)
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin ke halaman ini.');
        }

        return $next($request);
    }
}