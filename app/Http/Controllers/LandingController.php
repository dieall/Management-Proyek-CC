<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        // Kita bisa mengirim data tambahan ke landing page jika perlu
        // Contoh: Menampilkan 3 kegiatan terdekat di halaman depan
        $kegiatanTerdekat = \App\Models\Kegiatan::where('status_kegiatan', 'aktif')
                            ->whereDate('tanggal', '>=', now())
                            ->orderBy('tanggal', 'asc')
                            ->take(3)
                            ->get();

        return view('landing', compact('kegiatanTerdekat'));
    }
}