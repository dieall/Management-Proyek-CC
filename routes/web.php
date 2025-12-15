<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Import Model
use App\Models\Jamaah;
use App\Models\RiwayatDonasi;
use App\Models\Kegiatan;

// Import Controller
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JamaahController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. PUBLIC ROUTES (Bisa Diakses Siapa Saja)
// ====================================================

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Login Page
Route::get('/login', function () {
    return Auth::check() ? redirect()->route('home') : view('auth.login');
})->name('login');

// Proses Login
Route::post('/login', function (Request $request) {
    $request->validate(['username' => 'required', 'kata_sandi' => 'required']);
    
    $user = Jamaah::where('username', $request->username)->first();

    if ($user && Hash::check($request->kata_sandi, $user->kata_sandi)) {
        if (!$user->status_aktif) return back()->withErrors(['username' => 'Akun nonaktif.']);
        
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('home');
    }
    return back()->withErrors(['username' => 'Login gagal.']);
});

// Register Page
Route::get('/register', function () {
    return view('auth.register');
});

// Proses Register
Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'username'      => 'required|unique:jamaah',
        'nama_lengkap'  => 'required',
        'jenis_kelamin' => 'required',
        'kata_sandi'    => 'required|min:6|confirmed',
        'no_handphone'  => 'nullable',
        'alamat'        => 'nullable',
        'tanggal_lahir' => 'nullable|date',
    ]);

    $user = Jamaah::create($validated);
    Auth::login($user);

    return redirect()->route('home');
});

// Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});


// ====================================================
// 2. USER AREA (Wajib Login)
// ====================================================
Route::middleware(['auth'])->group(function () {
    
    // Halaman Home User
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Fitur Profil (Lihat & Update)
    Route::get('/profile', [HomeController::class, 'profile'])->name('user.profile');
    
    // [BARU] Route untuk memproses form update profil
    Route::put('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update');
    
    // Fitur User Lainnya
    Route::get('/my-donasi', [HomeController::class, 'riwayatDonasi'])->name('user.donasi');
    Route::get('/my-kegiatan', [HomeController::class, 'riwayatKegiatan'])->name('user.kegiatan');

});


// ====================================================
// 3. ADMIN AREA (Wajib Login & Kategori Admin)
// ====================================================
Route::middleware(['auth', 'is_admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        $stats = [
            'total_jamaah' => Jamaah::count(),
            'total_donasi' => RiwayatDonasi::sum('besar_donasi'),
            'kegiatan_aktif' => Kegiatan::where('status_kegiatan', 'aktif')->count(),
        ];

        $terbaruDonasi = RiwayatDonasi::with(['jamaah', 'donasi'])
                         ->latest('tanggal_donasi')
                         ->take(5)
                         ->get();

        $kegiatanTerdekat = Kegiatan::where('status_kegiatan', 'aktif')
                            ->whereDate('tanggal', '>=', now())
                            ->orderBy('tanggal', 'asc')
                            ->take(3)
                            ->get();

        return view('dashboard', compact('stats', 'terbaruDonasi', 'kegiatanTerdekat'));
        
    })->name('dashboard');

    // CRUD Resources
    Route::resource('jamaah', JamaahController::class);
    Route::resource('donasi', DonasiController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('kategori', KategoriController::class);
});