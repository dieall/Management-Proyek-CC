<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    protected $table = 'aset';
    use HasFactory;

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'jenis_aset',
        'deskripsi',
        'kondisi',
        'lokasi',
        'sumber_perolehan',
        'harga',
        'vendor',
        'tanggal_pembelian',
        'nilai_donasi',
        'donatur',
        'tanggal_donasi',
        'foto',
        'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'nilai_donasi' => 'decimal:2',
            'tanggal_pembelian' => 'date',
            'tanggal_donasi' => 'date',
            'is_archived' => 'boolean',
        ];
    }

    public function jadwalPerawatan()
    {
        return $this->hasMany(JadwalPerawatan::class);
    }

    public function laporanPerawatan()
    {
        return $this->hasMany(LaporanPerawatan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }
}
