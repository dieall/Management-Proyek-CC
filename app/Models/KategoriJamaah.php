<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJamaah extends Model
{
    use HasFactory;

    protected $table = 'kategori_jamaah';

    // Primary Key composite
    public $incrementing = false;
    protected $primaryKey = null;

    // PENTING: Matikan timestamps sesuai file migration
    public $timestamps = false;

    protected $fillable = [
        'id_jamaah',
        'id_kategori',
        'status_aktif',
        'periode',
    ];

    // PHP 8.4 / Laravel 12 Casting Style
    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    // Relasi balik ke Jamaah
    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah', 'id_jamaah');
    }

    // Relasi balik ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}