<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahan untuk hashing password

class HomeController extends Controller
{
    // ====================================================
    // Halaman Home User
    // ====================================================
    public function index()
    {
        $user = Auth::user();
        
        $totalDonasiKu = $user->riwayatDonasi()->sum('besar_donasi');
        $kegiatanKu = $user->kegiatan()->where('status_kegiatan', 'aktif')->count();

        return view('home', compact('user', 'totalDonasiKu', 'kegiatanKu'));
    }

    // ====================================================
    // Halaman Profil Saya
    // ====================================================
    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'no_handphone'  => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string|max:500',
            // Validasi password: opsional, min 8 karakter, harus sama dengan konfirmasi
            'password'      => 'nullable|string|min:8|confirmed',
        ]);

        // Siapkan data yang akan diupdate (tanpa password dulu)
        $dataToUpdate = [
            'nama_lengkap'  => $validated['nama_lengkap'],
            'no_handphone'  => $validated['no_handphone'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat'        => $validated['alamat'],
        ];

        // Cek jika user mengisi password baru
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // Lakukan update ke database
        $user->update($dataToUpdate);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ====================================================
    // Riwayat Donasi (Search & Filter)
    // ====================================================
    public function riwayatDonasi(Request $request)
    {
        $query = Auth::user()->riwayatDonasi()->with('donasi');

        // Filter: Pencarian Nama Program Donasi
        if ($request->has('q') && $request->q != '') {
            $query->whereHas('donasi', function($q) use ($request) {
                $q->where('nama_donasi', 'like', '%' . $request->q . '%');
            });
        }

        // Filter: Tanggal Mulai
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tanggal_donasi', '>=', $request->start_date);
        }

        // Filter: Tanggal Akhir
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tanggal_donasi', '<=', $request->end_date);
        }

        $riwayat = $query->latest('tanggal_donasi')->get();
                       
        return view('user.my_donasi', compact('riwayat'));
    }

    // ====================================================
    // Riwayat Kegiatan (Search & Filter)
    // ====================================================
    public function riwayatKegiatan(Request $request)
    {
        $query = Auth::user()->kegiatan();

        // Filter: Pencarian Nama Kegiatan atau Lokasi
        if ($request->has('q') && $request->q != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->q . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->q . '%');
            });
        }

        // Filter: Status Kegiatan (Aktif/Selesai/Batal)
        if ($request->has('status') && $request->status != '') {
            $query->where('status_kegiatan', $request->status);
        }

        $kegiatan = $query->latest('tanggal')->get();

        return view('user.my_kegiatan', compact('kegiatan'));
    }
}