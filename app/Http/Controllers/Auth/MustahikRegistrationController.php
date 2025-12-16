<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MustahikRegistrationController extends Controller
{
    /**
     * Tampilkan view pendaftaran Mustahik.
     */
    public function create(): View
    {
        $kategoriMustahik = [
            'Fakir', 
            'Miskin', 
            'Gharim', 
            'Muallaf', 
            'Ibnu Sabil'
        ];

        return view('auth.register-mustahik', compact('kategoriMustahik'));
    }

    /**
     * Tangani permintaan pendaftaran Mustahik.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'kategori_mustahik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15|unique:mustahik,no_hp',
            'password' => 'required|string|min:8|confirmed',
            'surat_dtks' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ], [
            'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'surat_dtks.required' => 'Dokumen Surat DTKS wajib diunggah.',
            'surat_dtks.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $filePath = null;

        // 2. Upload File Surat DTKS
        if ($request->hasFile('surat_dtks')) {
            $filePath = $request->file('surat_dtks')->store('mustahik_dtks', 'public');
        }

        // 3. Simpan data Mustahik
        Mustahik::create([
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'kategori_mustahik' => $validatedData['kategori_mustahik'],
            'no_hp' => $validatedData['no_hp'],
            'password' => Hash::make($validatedData['password']),
            'surat_dtks' => $filePath, 
            'status_verifikasi' => 'pending', 
        ]);

        // 4. Redirect dan Beri Notifikasi
        return redirect()->route('login')->with('success', 
            'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh petugas ZIS sebelum dapat login.');
    }
}