<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Mustahik; 

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Menggunakan tipe 'user' (Standar Laravel Auth) untuk Admin, Petugas, dan Muzakki.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            // Hanya ada 'user' dan 'mustahik'
            'login_type' => 'required|in:user,mustahik' 
        ]);

        $loginType = $request->login_type;
        $username = $request->username;
        $password = $request->password;
        $errorMessage = 'Kredensial login tidak cocok.'; 

        // --- 1. Login sebagai USER (Admin, Petugas, Jemaah/Muzakki) ---
        if ($loginType === 'user') {
            if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                // Redirect ke /dashboard, yang akan memilah berdasarkan role (Admin, Petugas, User/Muzakki)
                return redirect()->intended(route('dashboard'));
            }
        } 
        
        // --- 2. Login sebagai MUSTAHIK (Berbasis Session Kustom) ---
        elseif ($loginType === 'mustahik') {
            // Memanggil method authenticate di Model Mustahik (asumsi method ini ada)
            $mustahik = Mustahik::authenticate($username, $password);
            
            if ($mustahik) {
                $request->session()->regenerate();
                // Simpan data identifikasi Mustahik ke Session
                session([
                    'mustahik_id' => $mustahik->id_mustahik,
                    'mustahik_nama' => $mustahik->nama,
                    'user_type' => 'mustahik'
                ]);
                return redirect()->route('mustahik.dashboard');
            }
        }

        // Jika semua gagal, kembali ke form login dengan error
        return back()->withErrors([
            'username' => $errorMessage,
        ])->onlyInput('username');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 1. Logout Auth Guard standar (Admin/User/Muzakki)
        if (Auth::check()) {
            Auth::logout();
        }

        // 2. Hapus Session Kustom (Mustahik)
        // Session 'muzakki_id' tidak perlu dihapus di sini karena Muzakki sekarang login via Auth::check()
        $request->session()->forget(['mustahik_id', 'user_type', 'mustahik_nama']);

        // 3. Invalidate Session dan Regenerate Token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}