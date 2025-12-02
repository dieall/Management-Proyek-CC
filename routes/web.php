<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZisMasukController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Admin Routes (Petugas ZIS)
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ZIS Masuk Management
    Route::resource('zis', ZisMasukController::class)->names('zis.masuk');
    
    // Penyaluran Management
    Route::resource('penyaluran', PenyaluranController::class);
    
    // Muzakki Management
    Route::resource('muzakki', MuzakkiController::class);
    
    // Mustahik Management
    Route::resource('mustahik', MustahikController::class);
});

// Public Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::resource('zis', ZisMasukController::class)->names('zis.masuk')->middleware('auth');
Route::resource('penyaluran', PenyaluranController::class)->middleware('auth');
Route::resource('muzakki', MuzakkiController::class)->middleware('auth');
Route::resource('mustahik', MustahikController::class)->middleware('auth');
