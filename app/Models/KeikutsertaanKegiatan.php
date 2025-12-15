<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeikutsertaanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'keikutsertaan_kegiatan';

    // Karena Primary Key-nya composite (gabungan 2 kolom), kita matikan incrementing
    public $incrementing = false;
    protected $primaryKey = null;

    // PENTING: Matikan timestamps karena di migration tidak ada $table->timestamps()
    public $timestamps = false;

    protected $fillable = [
        'id_jamaah',
        'id_kegiatan',
        'tanggal_daftar',
        'status_kehadiran',
    ];

    // PHP 8.4 / Laravel 12 Casting Style
    protected function casts(): array
    {
        return [
            'tanggal_daftar' => 'date',
        ];
    }

    // Relasi balik ke Jamaah
    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah', 'id_jamaah');
    }

    // Relasi balik ke Kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }
}