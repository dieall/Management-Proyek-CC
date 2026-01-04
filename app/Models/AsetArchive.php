<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsetArchive extends Model
{
    protected $table = 'aset_archive';
    use HasFactory;

    protected $fillable = [
        'aset_id',
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
        'archived_by',
        'alasan_archive',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'nilai_donasi' => 'decimal:2',
            'tanggal_pembelian' => 'date',
            'tanggal_donasi' => 'date',
            'archived_at' => 'datetime',
        ];
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }
}
