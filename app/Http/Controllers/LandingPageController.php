<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        
        // Ambil jadwal sholat dari API Kota Bandung
        $today = strtolower(date('l')); // monday, tuesday, etc
        $todayDate = date('Y-m-d');

        $apiResponse = Http::get('https://api.aladhan.com/v1/timingsByCity', [
            'city'    => 'Bandung',
            'country' => 'Indonesia',
            'method'  => 20, // metode hisab (boleh disesuaikan)
            'date'    => $todayDate,
        ]);

        $schedules = [];

        if ($apiResponse->ok() && isset($apiResponse->json()['data']['timings'])) {
            $timings = $apiResponse->json()['data']['timings'];

            // Mapping nama waktu sholat ke label Indonesia
            $prayerMap = [
                'Fajr'    => 'Subuh',
                'Sunrise' => 'Terbit',
                'Dhuhr'   => 'Dzuhur',
                'Asr'     => 'Ashar',
                'Maghrib' => 'Maghrib',
                'Isha'    => 'Isya',
            ];

            foreach ($prayerMap as $key => $label) {
                $schedules[] = [
                    'prayer_name' => $label,
                    'time'        => $timings[$key] ?? null,
                ];
            }
        }
        
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

