<?php

namespace App\Http\Middleware; // Pastikan namespace ini benar

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMustahikSession // Pastikan nama class ini benar
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('mustahik_id')) {
            if (Auth::check()) {
                Auth::logout();
            }
            return redirect()->route('mustahik.login')->with('error', 'Akses ditolak. Silakan login sebagai Mustahik.');
        }
        
        return $next($request);
    }
}