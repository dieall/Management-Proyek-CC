<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    use HasFactory;

    protected $table = 'penyaluran';
    protected $primaryKey = 'id_penyaluran';

    protected $fillable = [
        'id_zis',
        'tgl_salur',
        'jumlah',
        'keterangan',
        'id_mustahik',
    ];

    protected $casts = [
        'tgl_salur' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relasi ke ZIS Masuk
    public function zisMasuk()
    {
        return $this->belongsTo(ZisMasuk::class, 'id_zis');
    }

    // Relasi ke Mustahik
    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'id_mustahik');
    }
}













