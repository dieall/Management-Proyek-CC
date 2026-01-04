<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'lokasi',
        'status_kegiatan',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi Many-to-Many dengan Users (Jamaah)
    public function peserta()
    {
        return $this->belongsToMany(User::class, 'keikutsertaan_kegiatan', 'id_kegiatan', 'id_jamaah')
                    ->withPivot('tanggal_daftar', 'status_kehadiran');
    }

    // Scope untuk filter status
    public function scopeAktif($query)
    {
        return $query->where('status_kegiatan', 'aktif');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_kegiatan', 'selesai');
    }
}

