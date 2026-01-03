<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MustahikLoginController extends Controller
{
    /**
     * Show the Mustahik login form.
     */
    public function create(): View
    {
        return view('auth.login-mustahik');
    }

    /**
     * Handle an incoming Mustahik login request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username atau Nomor HP harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // Cari Mustahik berdasarkan nama atau no_hp
        $mustahik = Mustahik::where('no_hp', $validated['username'])
            ->orWhere('nama', $validated['username'])
            ->first();

        // Cek apakah Mustahik ditemukan dan password cocok
        if (!$mustahik || !Hash::check($validated['password'], $mustahik->password)) {
            return back()->withErrors([
                'username' => 'Username/Nomor HP atau password salah',
            ])->withInput($request->only('username'));
        }

        // Cek status verifikasi
        if ($mustahik->status_verifikasi !== 'disetujui') {
            return back()->with('error', 'Akun Mustahik Anda belum disetujui oleh Admin. Hubungi admin untuk informasi lebih lanjut.');
        }

        // Simpan session Mustahik
        session([
            'mustahik_id' => $mustahik->id_mustahik,
            'mustahik_nama' => $mustahik->nama,
            'mustahik_no_hp' => $mustahik->no_hp,
        ]);

        return redirect()->route('mustahik.dashboard')->with('success', 'Selamat datang, ' . $mustahik->nama . '!');
    }

    /**
     * Handle Mustahik logout.
     */
    public function destroy(): RedirectResponse
    {
        session()->forget([
            'mustahik_id',
            'mustahik_nama',
            'mustahik_no_hp',
        ]);

        return redirect()->route('home')->with('success', 'Logout berhasil');
    }
}
