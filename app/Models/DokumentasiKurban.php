<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiKurban extends Model
{
    use HasFactory;

    protected $table = 'kurban_dokumentasi';
    protected $primaryKey = 'id_dokumentasi';

    protected $fillable = [
        'id_riwayat_kurban',
        'jenis_dokumentasi',
        'foto',
        'keterangan',
    ];

    // Relasi ke RiwayatKurban
    public function riwayatKurban()
    {
        return $this->belongsTo(RiwayatKurban::class, 'id_riwayat_kurban');
    }
}

