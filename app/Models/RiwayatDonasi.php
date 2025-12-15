<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDonasi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_donasi';
    
    public $incrementing = false;
    protected $primaryKey = null; 
    public $timestamps = false;

    protected $fillable = [
        'id_jamaah', 
        'id_donasi', 
        'besar_donasi', 
        'tanggal_donasi'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_donasi' => 'date',
            'besar_donasi'   => 'decimal:2',
        ];
    }

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah', 'id_jamaah');
    }

    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'id_donasi', 'id_donasi');
    }
}