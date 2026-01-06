<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'name',
        'email',
        'no_hp',
        'alamat',
        'password',
        'role',
        'status_aktif',
        'tanggal_daftar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods untuk role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdminOrSuper()
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    public function isPanitia()
    {
        return $this->role === 'panitia';
    }

    public function isDkm()
    {
        return $this->role === 'dkm';
    }

    public function isJemaah()
    {
        return $this->role === 'jemaah';
    }

    public function isMuzakki()
    {
        return $this->role === 'muzakki';
    }

    public function isMustahik()
    {
        return $this->role === 'mustahik';
    }

    // Relasi untuk modul Inventaris
    public function jadwalPerawatan()
    {
        return $this->hasMany(JadwalPerawatan::class);
    }

    public function laporanPerawatan()
    {
        return $this->hasMany(LaporanPerawatan::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    // Relasi untuk modul Jamaah/Kegiatan/Donasi
    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_jamaah', 'id_jamaah', 'id_kategori')
                    ->withPivot('status_aktif', 'periode');
    }

    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class, 'keikutsertaan_kegiatan', 'id_jamaah', 'id_kegiatan')
                    ->withPivot('tanggal_daftar', 'status_kehadiran');
    }

    public function donasis()
    {
        return $this->belongsToMany(Donasi::class, 'riwayat_donasi', 'id_jamaah', 'id_donasi')
                    ->withPivot('besar_donasi', 'tanggal_donasi');
    }

    // Relasi untuk modul Event
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations', 'user_id', 'event_id')
                    ->withPivot('tanggal_daftar', 'status_kehadiran')
                    ->withTimestamps();
    }

    // Relasi untuk modul Takmir
    public function committee()
    {
        return $this->hasOne(Committee::class);
    }

    // Relasi ke Muzakki (pemberi ZIS)
    public function muzakki()
    {
        return $this->hasOne(Muzakki::class, 'user_id');
    }

    // Relasi ke Mustahik (penerima ZIS) - opsional, jika dihubungkan ke users
    public function mustahik()
    {
        return $this->hasOne(Mustahik::class, 'user_id');
    }
}
