<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\WeeklyPrayerSchedule;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        
        // Ambil artikel yang aktif (untuk public)
        $articles = Article::where('is_active', true)
                          ->orderBy('order', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->limit(6)
                          ->get();
        
        // Ambil jadwal sholat
        $schedules = WeeklyPrayerSchedule::all();
        $today = strtolower(date('l')); // monday, tuesday, etc
        
        // Format hari Indonesia
        $hariIndonesia = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu'
        ];
        $todayIndonesian = $hariIndonesia[$today] ?? ucfirst($today);
        
        return view('landing', compact('articles', 'schedules', 'today', 'todayIndonesian'));
    }
}

