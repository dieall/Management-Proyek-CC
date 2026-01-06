<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\JadwalPerawatanController;
use App\Http\Controllers\LaporanPerawatanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\ZisMasukController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\WeeklyPrayerScheduleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\JobResponsibilityController;
use App\Http\Controllers\DutyScheduleController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\OrganizationalStructureController;
use App\Http\Controllers\KurbanController;
use App\Http\Controllers\LandingPageController;

// Landing Page (Public)
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Event Routes
    Route::resource('events', EventController::class);
    Route::post('events/{id}/daftar', [EventController::class, 'daftar'])->name('events.daftar');
    Route::get('events/{id}/peserta', [EventController::class, 'peserta'])->name('events.peserta');
    Route::post('events/{id}/absensi', [EventController::class, 'updateAbsensi'])->name('events.absensi');
    
    // Aset Routes
    Route::resource('aset', AsetController::class);
    Route::post('aset/{id}/archive', [AsetController::class, 'archive'])->name('aset.archive');
    Route::post('aset/{id}/restore', [AsetController::class, 'restore'])->name('aset.restore');
    Route::get('aset/{id}/qr', [AsetController::class, 'qr'])->name('aset.qr');
    
    // Jadwal Perawatan Routes
    Route::resource('jadwal-perawatan', JadwalPerawatanController::class);
    
    // Laporan Perawatan Routes
    Route::resource('laporan-perawatan', LaporanPerawatanController::class);
    
    // Log Aktivitas Routes
    Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    
    // Kegiatan Routes
    Route::resource('kegiatan', KegiatanController::class);
    Route::post('kegiatan/{id}/daftar', [KegiatanController::class, 'daftar'])->name('kegiatan.daftar');
    Route::post('kegiatan/{id}/kehadiran', [KegiatanController::class, 'updateKehadiran'])->name('kegiatan.kehadiran');
    
    // Donasi Routes
    Route::resource('donasi', DonasiController::class);
    Route::post('donasi/{id}/submit', [DonasiController::class, 'submitDonasi'])->name('donasi.submit');
    Route::get('my-donations', [DonasiController::class, 'myDonations'])->name('donasi.my-donations');
    
    // Kurban Routes
    Route::resource('kurban', KurbanController::class);
    Route::post('kurban/{id}/submit', [KurbanController::class, 'submitPendaftaran'])->name('kurban.submit');
    Route::patch('kurban/status/{id}', [KurbanController::class, 'updateStatus'])->name('kurban.update-status');
    Route::post('kurban/dokumentasi/upload', [KurbanController::class, 'uploadDokumentasi'])->name('kurban.upload-dokumentasi');
    Route::delete('kurban/dokumentasi/{id}', [KurbanController::class, 'deleteDokumentasi'])->name('kurban.delete-dokumentasi');
    Route::get('my-kurban', [KurbanController::class, 'myKurban'])->name('kurban.my-kurban');
    
    // ZIS Management Routes
    Route::resource('muzakki', MuzakkiController::class);
    Route::post('muzakki/{id}/approve', [MuzakkiController::class, 'approve'])->name('muzakki.approve');
    Route::post('muzakki/{id}/reject', [MuzakkiController::class, 'reject'])->name('muzakki.reject');
    
    Route::resource('mustahik', MustahikController::class);
    
    Route::resource('zis-masuk', ZisMasukController::class);
    Route::get('zis-masuk-laporan', [ZisMasukController::class, 'laporan'])->name('zis-masuk.laporan');
    Route::get('my-zis', [ZisMasukController::class, 'myZis'])->name('zis-masuk.my-zis');
    
    Route::resource('penyaluran', PenyaluranController::class);
    Route::get('penyaluran-laporan', [PenyaluranController::class, 'laporan'])->name('penyaluran.laporan');
    Route::get('my-penyaluran', [PenyaluranController::class, 'myPenyaluran'])->name('penyaluran.my-penyaluran');
    
    // Informasi & Pengumuman Routes
    Route::resource('articles', ArticleController::class);
    Route::resource('masjids', MasjidController::class);
    Route::resource('prayer-schedules', WeeklyPrayerScheduleController::class);
    
    // Manajemen Takmir/Pengurus Routes
    Route::resource('positions', PositionController::class);
    Route::resource('committees', CommitteeController::class);
    Route::resource('job-responsibilities', JobResponsibilityController::class);
    Route::resource('duty-schedules', DutyScheduleController::class);
    Route::resource('task-assignments', TaskAssignmentController::class);
    Route::resource('organizational-structures', OrganizationalStructureController::class);
});
