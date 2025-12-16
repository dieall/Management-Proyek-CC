<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMuzakkiSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('muzakki_id')) {
            // Hapus Auth standar jika ada, untuk memaksa login ulang dengan tipe yang benar
            if (auth()->check()) {
                auth()->logout();
            }
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai Muzakki.');
        }
        
        return $next($request);
    }
}