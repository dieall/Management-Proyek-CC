<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPerawatan extends Model
{
    protected $table = 'laporan_perawatan';
    use HasFactory;

    protected $fillable = [
        'jadwal_perawatan_id',
        'aset_id',
        'user_id',
        'tanggal_pemeriksaan',
        'kondisi_sebelum',
        'kondisi_sesudah',
        'hasil_pemeriksaan',
        'tindakan',
        'biaya_perawatan',
        'foto_sebelum',
        'foto_sesudah',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pemeriksaan' => 'date',
            'biaya_perawatan' => 'decimal:2',
        ];
    }

    public function jadwalPerawatan()
    {
        return $this->belongsTo(JadwalPerawatan::class);
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
