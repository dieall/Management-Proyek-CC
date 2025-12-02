<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\ZisMasuk;
use App\Models\Penyaluran;
use App\Models\Muzakki;
use App\Models\Mustahik;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View|RedirectResponse
    {
        // Check if user is authenticated and is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $totalZis = ZisMasuk::sum('jumlah');
        $totalPenyaluran = Penyaluran::sum('jumlah');
        $sisaDana = $totalZis - $totalPenyaluran;
        
        $countMuzakki = Muzakki::count();
        $countMustahik = Mustahik::count();
        $countZismasuk = ZisMasuk::count();
        $countPenyaluran = Penyaluran::count();

        // Get recent transactions
        $recentZis = ZisMasuk::with('muzakki')
            ->orderBy('tgl_masuk', 'desc')
            ->limit(5)
            ->get();

        $recentPenyaluran = Penyaluran::with(['zismasuk', 'mustahik'])
            ->orderBy('tgl_salur', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'totalZis' => $totalZis,
            'totalPenyaluran' => $totalPenyaluran,
            'sisaDana' => $sisaDana,
            'countMuzakki' => $countMuzakki,
            'countMustahik' => $countMustahik,
            'countZismasuk' => $countZismasuk,
            'countPenyaluran' => $countPenyaluran,
            'recentZis' => $recentZis,
            'recentPenyaluran' => $recentPenyaluran,
        ]);
    }
}
