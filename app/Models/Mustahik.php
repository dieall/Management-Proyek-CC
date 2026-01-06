<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mustahik extends Model
{
    use HasFactory;

    protected $table = 'mustahik';
    protected $primaryKey = 'id_mustahik';

    protected $fillable = [
        'nama',
        'alamat',
        'kategori_mustahik',
        'no_hp',
        'status_verifikasi',
        'surat_dtks',
        'status',
        'password',
        'tgl_daftar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_daftar' => 'datetime',
    ];

    // Relasi ke Penyaluran
    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_mustahik');
    }

    // Total penerimaan
    public function totalPenerimaan()
    {
        return $this->penyaluran()->sum('jumlah');
    }

    // Scope filter
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status_verifikasi', 'disetujui');
    }
}









