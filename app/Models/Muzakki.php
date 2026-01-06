<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muzakki extends Model
{
    use HasFactory;

    protected $table = 'muzakki';
    protected $primaryKey = 'id_muzakki';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_hp',
        'password',
        'tgl_daftar',
        'status_pendaftaran',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_daftar' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke ZIS Masuk
    public function zisMasuk()
    {
        return $this->hasMany(ZisMasuk::class, 'id_muzakki');
    }

    // Scope filter
    public function scopeDisetujui($query)
    {
        return $query->where('status_pendaftaran', 'disetujui');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status_pendaftaran', 'menunggu');
    }
}










