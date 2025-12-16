<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MuzakkiRegistrationController extends Controller
{
    /**
     * Proses pendaftaran Muzakki dari Dashboard User.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Cek duplikasi
        if ($user->muzakkiProfile) {
            return redirect()->route('user.dashboard')->with('error', 'Anda sudah mengajukan pendaftaran Muzakki.');
        }

        // Simpan data pendaftaran (mengambil data profil dari tabel users)
        // Password diisi agar Muzakki bisa login di sistem lama, meskipun sekarang tidak dipakai
        Muzakki::create([
            'user_id' => $user->id,
            'nama' => $user->nama_lengkap,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
            'password' => $user->password, 
            'status_pendaftaran' => 'menunggu',
            'tgl_daftar' => now(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran Muzakki berhasil diajukan! Mohon tunggu persetujuan Admin.');
    }
    
    /**
     * Admin menyetujui pendaftaran Muzakki (Dipanggil via rute POST admin.muzakki.approve).
     */
    public function approve(Muzakki $muzakki): RedirectResponse
    {
        $muzakki->update(['status_pendaftaran' => 'disetujui']);
        return back()->with('success', 'Pendaftaran Muzakki berhasil disetujui.');
    }
}