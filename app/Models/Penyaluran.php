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

    protected function casts(): array
    {
        return [
            'tgl_salur' => 'date',
            'jumlah' => 'decimal:2',
        ];
    }

    // Relations
    public function zismasuk()
    {
        return $this->belongsTo(ZisMasuk::class, 'id_zis');
    }

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'id_mustahik');
    }
}
