<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ZakatCalculatorController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Cek Login & Status Muzakki
        $user->load('muzakkiProfile');
        $muzakkiProfile = $user->muzakkiProfile;

        if (!$muzakkiProfile || $muzakkiProfile->status_pendaftaran !== 'disetujui') {
             return redirect()->route('user.dashboard')
                ->with('error', 'Akses kalkulator dibatasi.');
        }

        // --- KONFIGURASI ZAKAT ---
        
        $fitrahAmount = [
            'beras_kg' => '3.5 liter / 2.5 kg',
            'uang_rp' => 55000, 
        ];

        // HARGA EMAS SAAT INI (Update berkala/ambil dari API)
        // Misal: Rp 1.300.000 per gram
        $hargaEmasPerGram = 1300000; 

        // 1. Nishab Tahunan (Untuk Zakat Maal/Harta Simpanan) -> 85 gram emas
        $nishabTahun = 85 * $hargaEmasPerGram; 
        
        // 2. Nishab Bulanan (Untuk Zakat Penghasilan) -> Nishab Tahun / 12 bulan
        // SK BAZNAS biasanya menggunakan pendekatan ini atau setara 653kg beras
        $nishabBulan = $nishabTahun / 12;

        return view('user.kalkulator.index', compact(
            'fitrahAmount', 
            'nishabTahun', 
            'nishabBulan',
            'hargaEmasPerGram'
        ));
    }
}