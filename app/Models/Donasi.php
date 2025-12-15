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

    // UPDATED: Modern Casting
    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function donatur()
    {
        return $this->belongsToMany(Jamaah::class, 'riwayat_donasi', 'id_donasi', 'id_jamaah')
                    ->withPivot(['besar_donasi', 'tanggal_donasi']);
    }

    public function riwayatTransaksi()
    {
        return $this->hasMany(RiwayatDonasi::class, 'id_donasi', 'id_donasi');
    }
}