<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Jamaah extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'jamaah';
    protected $primaryKey = 'id_jamaah';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'kata_sandi',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_handphone',
        'tanggal_bergabung',
        'status_aktif',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    // UPDATED: Modern Casting untuk Laravel 12
    protected function casts(): array
    {
        return [
            'tanggal_lahir'     => 'date',
            'tanggal_bergabung' => 'date',
            'status_aktif'      => 'boolean',
            'kata_sandi'        => 'hashed', // Otomatis hash jika diset
        ];
    }

    // Override kolom password default
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_jamaah', 'id_jamaah', 'id_kategori')
                    ->withPivot(['status_aktif', 'periode']);
    }

    public function kegiatan()
    {
        return $this->belongsToMany(Kegiatan::class, 'keikutsertaan_kegiatan', 'id_jamaah', 'id_kegiatan')
                    ->withPivot(['tanggal_daftar', 'status_kehadiran']);
    }

    public function donasi()
    {
        return $this->belongsToMany(Donasi::class, 'riwayat_donasi', 'id_jamaah', 'id_donasi')
                    ->withPivot(['besar_donasi', 'tanggal_donasi']);
    }

    public function riwayatDonasi()
    {
        return $this->hasMany(RiwayatDonasi::class, 'id_jamaah', 'id_jamaah');
    }

    public function isAdmin()
    {
        // Cek relasi kategori, apakah ada yang namanya 'Admin Masjid' atau 'Pengurus DKM'
        return $this->kategori()
                    ->where(function($query) {
                        $query->where('nama_kategori', 'Admin Masjid')
                              ->orWhere('nama_kategori', 'Pengurus DKM'); // Jaga-jaga jika pakai nama ini di seeder
                    })
                    ->wherePivot('status_aktif', true) // Pastikan status di pivot aktif
                    ->exists();
    }
}