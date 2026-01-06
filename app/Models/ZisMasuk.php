<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZisMasuk extends Model
{
    use HasFactory;

    protected $table = 'zis_masuk';
    protected $primaryKey = 'id_zis';

    protected $fillable = [
        'id_muzakki',
        'tgl_masuk',
        'jenis_zis',
        'sub_jenis_zis',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relasi ke Muzakki
    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class, 'id_muzakki');
    }

    // Relasi ke Penyaluran
    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_zis');
    }

    // Total yang sudah disalurkan
    public function totalDisalurkan()
    {
        return $this->penyaluran()->sum('jumlah');
    }

    // Sisa yang belum disalurkan
    public function sisaBelumDisalurkan()
    {
        return $this->jumlah - $this->totalDisalurkan();
    }

    // Scope filter berdasarkan jenis
    public function scopeZakat($query)
    {
        return $query->where('jenis_zis', 'zakat');
    }

    public function scopeInfaq($query)
    {
        return $query->where('jenis_zis', 'infaq');
    }

    public function scopeShadaqah($query)
    {
        return $query->where('jenis_zis', 'shadaqah');
    }

    public function scopeWakaf($query)
    {
        return $query->where('jenis_zis', 'wakaf');
    }
}










