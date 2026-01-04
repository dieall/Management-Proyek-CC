<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';

    protected $fillable = [
        'nama_donasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi Many-to-Many dengan Users (Jamaah) melalui riwayat_donasi
    public function donatur()
    {
        return $this->belongsToMany(User::class, 'riwayat_donasi', 'id_donasi', 'id_jamaah')
                    ->withPivot('besar_donasi', 'tanggal_donasi');
    }

    // Helper: Total donasi yang terkumpul
    public function totalDonasi()
    {
        return $this->donatur()->sum('besar_donasi');
    }
}

