<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasjidController;

// Public route
Route::get('/', [MasjidController::class, 'index'])->name('masjid.index');

// Admin routes
Route::get('/admin', [MasjidController::class, 'edit'])->name('masjid.edit');
Route::post('/admin/masjid/update', [MasjidController::class, 'update'])->name('masjid.update');

// Articles
Route::post('/admin/article/add', [MasjidController::class, 'addArticle'])->name('article.add');
Route::post('/admin/article/{article}/update', [MasjidController::class, 'updateArticle'])->name('article.update');
Route::post('/admin/article/{article}/delete', [MasjidController::class, 'deleteArticle'])->name('article.delete');

// Jadwal shalat: manajemen (tambah/ubah/hapus) dinonaktifkan pada panel admin



