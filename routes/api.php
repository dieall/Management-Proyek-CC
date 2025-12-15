<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JamaahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DonasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (Tidak butuh Token)
// =========================================================================

Route::post('/register', [JamaahController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// =========================================================================
// 2. PROTECTED ROUTES (Butuh Token Sanctum)
// =========================================================================

Route::middleware('auth:sanctum')->group(function () {
    
    // --- AUTH & PROFILE ---
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [JamaahController::class, 'me']);
    Route::put('/me', [JamaahController::class, 'updateProfile']);
    Route::post('/me/password', [JamaahController::class, 'changePassword']);

    // --- MANAJEMEN JAMAAH (ADMIN) ---
    Route::get('/jamaah-export', [JamaahController::class, 'export']); // Export CSV
    Route::apiResource('jamaah', JamaahController::class); // CRUD lengkap (index, store, show, update, destroy)
    
    // Relasi Jamaah Spesifik
    Route::post('/jamaah/{id}/sync-kategori', [JamaahController::class, 'syncKategori']);
    Route::get('/jamaah/{id}/kegiatan', [JamaahController::class, 'kegiatan']);
    Route::get('/jamaah/{id}/donasi', [JamaahController::class, 'donasi']);

    // --- MANAJEMEN KATEGORI ---
    Route::apiResource('kategori', KategoriController::class);
    Route::get('/kategori/{id}/jamaah', [KategoriController::class, 'listJamaah']);
    Route::post('/kategori/{id}/tambah-jamaah', [KategoriController::class, 'tambahJamaah']);

    // --- MANAJEMEN KEGIATAN ---
    Route::apiResource('kegiatan', KegiatanController::class);
    Route::get('/kegiatan/{id}/peserta', [KegiatanController::class, 'peserta']);
    Route::post('/kegiatan/{id}/tambah-peserta', [KegiatanController::class, 'tambahPeserta']);
    Route::post('/kegiatan/{id}/status-kehadiran', [KegiatanController::class, 'ubahStatusKehadiran']);

    // --- MANAJEMEN DONASI ---
    Route::apiResource('donasi', DonasiController::class);
    Route::get('/donasi/{id}/donatur', [DonasiController::class, 'jamaah']); // List donatur
    Route::post('/donasi/{id}/catat', [DonasiController::class, 'catatDonasi']); // Input transaksi
});