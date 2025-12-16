<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ZakatCalculatorController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user()->load('muzakkiProfile');
        $muzakkiProfile = $user->muzakkiProfile;

        // Cek Persetujuan Admin
        if (!$muzakkiProfile || $muzakkiProfile->status_pendaftaran !== 'disetujui') {
             return redirect()->route('user.dashboard')->with('error', 'Akses kalkulator dibatasi untuk Muzakki yang sudah disetujui.');
        }

        // --- Data Kalkulator ---
        $fitrahAmount = [
            'beras_kg' => '3.5 liter',
            'uang_rp' => 55000, 
        ];

        // Nishab Emas Bulanan (Contoh nilai tetap)
        $nishab = 17585076; 
        
        // Data Sub-Jenis Zakat Maal
        $subJenisZakatMaal = [
            'Zakat Emas', 'Zakat Penghasilan', 'Zakat Tabungan', 'Zakat Perak', 
            'Zakat Perhiasan Perak', 'Zakat Perindustrian', 'Zakat Hasil Perniagaan', 
            'Zakat Pertambangan Emas', 'Zakat Pertambangan Perak', 'Zakat Perusahaan',
        ];

        return view('user.kalkulator.index', compact('fitrahAmount', 'nishab', 'subJenisZakatMaal'));
    }
}