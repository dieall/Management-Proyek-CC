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
        'jumlah',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tgl_masuk' => 'date',
            'jumlah' => 'decimal:2',
        ];
    }

    // Relations
    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class, 'id_muzakki');
    }

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_zis');
    }
}
