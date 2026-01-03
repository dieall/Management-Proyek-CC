<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\MustahikLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\ZisMasukController;
use App\Http\Controllers\MuzakkiRegistrationController; 
use App\Http\Controllers\ZakatCalculatorController;
use App\Http\Controllers\Auth\MustahikRegistrationController;

// --- Homepage ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- Authentication (Guest) ---
Route::middleware('guest')->group(function () {
    // Daftar Muzakki/Jemaah (Standard Laravel Register)
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    // Login Muzakki
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Login Mustahik
    Route::get('login/mustahik', [MustahikLoginController::class, 'create'])->name('mustahik.login');
    Route::post('login/mustahik', [MustahikLoginController::class, 'store'])->name('mustahik.login.store');
    
    // Daftar Mustahik (Rute Khusus)
    Route::get('/daftar/mustahik', [MustahikRegistrationController::class, 'create'])->name('mustahik.register');
    Route::post('/daftar/mustahik', [MustahikRegistrationController::class, 'store']);
});

// Logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Logout Mustahik
Route::post('logout/mustahik', [MustahikLoginController::class, 'destroy'])->name('mustahik.logout');


// --- Protected Routes (Auth Guard: User/Admin/Petugas) ---
Route::middleware('auth')->group(function () {
    
    // **ENDPOINT UMUM DASHBOARD (Redirector)**
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Petugas (Role: pengurus)
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugasDashboard'])->name('petugas.dashboard');
    
    
    // ----------------------------------------------------------------------------------
    // A. User Routes (Role: jemaah)
    // ----------------------------------------------------------------------------------
    Route::middleware('is.user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'userIndex'])->name('dashboard');
        
        // Pendaftaran Muzakki Mandiri
        Route::post('/register-muzakki', [MuzakkiRegistrationController::class, 'store'])->name('register-muzakki.store');
        
        // Kalkulator & Pembayaran
        Route::get('/kalkulator', [ZakatCalculatorController::class, 'index'])->name('kalkulator.index');
        Route::resource('pembayaran', ZisMasukController::class)
            ->only(['index', 'create', 'store', 'show']) 
            ->names('pembayaran');
    });

    
    // ----------------------------------------------------------------------------------
    // B. Admin Routes (Role: admin)
    // ----------------------------------------------------------------------------------
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/debug-mustahik', [DashboardController::class, 'debugMustahik'])->name('debug-mustahik');

        // Muzakki Management
        Route::resource('muzakki', MuzakkiController::class); 
        Route::post('muzakki/approve/{muzakki}', [MuzakkiRegistrationController::class, 'approve'])->name('muzakki.approve');
        
        // Mustahik Management
        Route::resource('mustahik', MustahikController::class); 
        
        // RUTE VERIFIKASI MUSTAHIK BARU
        Route::get('mustahik/verifikasi/{mustahik}', [MustahikController::class, 'showVerification'])->name('mustahik.verifikasi.show');
        Route::post('mustahik/approve/{mustahik}', [MustahikController::class, 'approve'])->name('mustahik.approve');
        
        // ZIS Masuk & Penyaluran
        Route::resource('zis-masuk', ZisMasukController::class)->names('zis.masuk');
        Route::resource('penyaluran', PenyaluranController::class);
    });
});
// ----------------------------------------------------------------------------------


// --- Mustahik Routes (Custom Session Guard) ---
Route::middleware(['mustahik.session'])->prefix('mustahik')->name('mustahik.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mustahikDashboard'])->name('dashboard');
    
    Route::get('/profil', [DashboardController::class, 'mustahikProfil'])->name('profil');
    Route::get('/riwayat', [DashboardController::class, 'mustahikRiwayat'])->name('riwayat');
});