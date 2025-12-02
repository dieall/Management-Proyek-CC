<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mustahik extends Model
{
    use HasFactory;

    protected $table = 'mustahik';
    protected $primaryKey = 'id_mustahik';

    protected $fillable = [
        'nama',
        'alamat',
        'kategori_mustahik',
        'no_hp',
        'surat_dtks',
        'status',
        'tgl_daftar',
    ];

    protected function casts(): array
    {
        return [
            'tgl_daftar' => 'datetime',
        ];
    }

    // Relations
    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_mustahik');
    }
}
