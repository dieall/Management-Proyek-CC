<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\ZisMasuk;
use App\Models\Penyaluran;
use App\Models\Muzakki;
use App\Models\Mustahik; // Pastikan Mustahik sudah diimpor
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirector: Arahkan user ke dashboard yang benar.
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        if ($user->role === 'admin') {
            return $this->adminDashboard(); 
        } elseif ($user->role === 'pengurus') {
            return redirect()->route('petugas.dashboard');
        } else { // Jemaah (Muzakki Portal)
            return redirect()->route('user.dashboard'); 
        }
    }

    /**
     * Display the admin dashboard. (DIPERBARUI)
     */
    protected function adminDashboard(): View
    {
        // Hitung Statistik Dasar
        $totalZis = ZisMasuk::sum('jumlah');
        $totalPenyaluran = Penyaluran::sum('jumlah');
        $sisaDana = $totalZis - $totalPenyaluran;
        
        // Hitung Total Data
        $countMuzakki = Muzakki::count(); 
        $countMustahik = Mustahik::count();
        $countZismasuk = ZisMasuk::count();
        $countPenyaluran = Penyaluran::count();
        
        // Ambil data untuk tabel approval MUZAKKI
        $muzakkiPending = Muzakki::where('status_pendaftaran', 'menunggu')
                                 ->with('user')
                                 ->orderBy('tgl_daftar', 'asc')
                                 ->limit(7) // Batasi tampilan di dashboard
                                 ->get();
                                 
        // --- TAMBAHAN BARU: MUSTAHIK PENDING ---
$mustahikPending = Mustahik::where('status_verifikasi', 'pending')
                           ->orderBy('created_at', 'asc')
                           ->limit(7)
                           ->get();


        // Ambil Transaksi Terbaru
        $recentZis = ZisMasuk::with('muzakki')->orderBy('tgl_masuk', 'desc')->limit(5)->get();
        $recentPenyaluran = Penyaluran::with(['zisMasuk', 'mustahik'])->orderBy('tgl_salur', 'desc')->limit(5)->get();

        return view('admin.index', compact( // DIUBAH DARI 'dashboard.index' ke 'admin.index'
            'totalZis', 
            'totalPenyaluran', 
            'sisaDana', 
            'countMuzakki', 
            'countMustahik', 
            'countZismasuk', 
            'countPenyaluran', 
            'recentZis', 
            'recentPenyaluran',
            'muzakkiPending',
            'mustahikPending' // <-- Variabel Mustahik Pending ditambahkan
        ));
    }
    
    /**
     * Display the user (jemaah) dashboard / Muzakki Portal (Pusat Approval).
     */
    public function userIndex(): View
    {
        $user = Auth::user()->load('muzakkiProfile');
        $muzakkiProfile = $user->muzakkiProfile; 

        $isMuzakkiRegistered = (bool)$muzakkiProfile; 
        $isMuzakkiApproved = $muzakkiProfile && $muzakkiProfile->status_pendaftaran === 'disetujui';

        $donasi = collect();
        $totalDonasi = 0;

        if ($isMuzakkiApproved) {
            $donasi = $muzakkiProfile->zismasuk()->latest()->get(); 
            $totalDonasi = $muzakkiProfile->zismasuk()->sum('jumlah');
        }
        
        return view('user.dashboard', compact(
            'user', 
            'muzakkiProfile', 
            'isMuzakkiRegistered', 
            'isMuzakkiApproved', 
            'donasi', 
            'totalDonasi'
        )); 
    }
    
    /**
     * Display the petugas dashboard.
     */
    public function petugasDashboard(): View
    {
        if (!Auth::check() || Auth::user()->role !== 'pengurus') {
            abort(403, 'Akses ditolak.');
        }
        $totalZis = ZisMasuk::sum('jumlah');
        $totalPenyaluran = Penyaluran::sum('jumlah');
        
        // Menggunakan Mustahik::where('status_verifikasi', 'pending') untuk konsistensi
        $mustahikMenunggu = Mustahik::where('status_verifikasi', 'pending')->count(); 
        
        return view('petugas.dashboard', compact('totalZis', 'totalPenyaluran', 'mustahikMenunggu'));
    }


    /**
     * Display the mustahik dashboard (Berbasis session).
     */
    public function mustahikDashboard(): View|RedirectResponse
    {
        $mustahikId = session('mustahik_id');
        if (!$mustahikId) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Mustahik.');
        }
        
        $mustahik = Mustahik::findOrFail($mustahikId);
        $penyaluran = $mustahik->penyaluran()->latest()->get();
        $totalDiterima = $mustahik->penyaluran()->sum('jumlah');
        
        return view('zis.mustahik.dashboard', compact('mustahik', 'penyaluran', 'totalDiterima'));
    }

    /**
     * Display the mustahik profile.
     */
    public function mustahikProfil(): View
    {
        $mustahikId = session('mustahik_id');
        $mustahik = Mustahik::findOrFail($mustahikId);
        
        return view('zis.mustahik.profil', compact('mustahik'));
    }

    /**
     * Display the mustahik distribution history.
     */
    public function mustahikRiwayat(): View
    {
        $mustahikId = session('mustahik_id');
        $mustahik = Mustahik::findOrFail($mustahikId);
        $penyaluran = $mustahik->penyaluran()->latest()->get();
        
        return view('zis.mustahik.riwayat', compact('mustahik', 'penyaluran'));
    }

    /**
     * Debug: Tampilkan semua data Mustahik (untuk testing)
     */
    public function debugMustahik(): View
    {
        $allMustahik = Mustahik::all();
        $pendingMustahik = Mustahik::where('status_verifikasi', 'pending')->get();
        
        return view('debug-mustahik', compact('allMustahik', 'pendingMustahik'));
    }
}