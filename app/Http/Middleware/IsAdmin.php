<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah user memiliki kategori Admin
        // (Menggunakan fungsi isAdmin() yang kita buat di Model tadi)
        if (!Auth::user()->isAdmin()) {
            // Jika bukan admin, tendang keluar atau tampilkan 403 Forbidden
            abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin Masjid.');
        }

        return $next($request);
    }
}