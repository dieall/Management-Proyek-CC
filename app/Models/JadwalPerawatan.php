<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPerawatan extends Model
{
    protected $table = 'jadwal_perawatan';
    use HasFactory;

    protected $fillable = [
        'aset_id',
        'jenis_perawatan',
        'deskripsi',
        'tanggal_jadwal',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jadwal' => 'date',
        ];
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporanPerawatan()
    {
        return $this->hasMany(LaporanPerawatan::class);
    }
}
