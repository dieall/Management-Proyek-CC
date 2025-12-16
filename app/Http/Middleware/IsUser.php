<?php
// app/Http/Middleware/IsUser.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Periksa apakah role user adalah 'jemaah' (role untuk user biasa)
        if (auth()->user()->role !== 'jemaah') {
            // Jika bukan jemaah (dan terautentikasi), arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}