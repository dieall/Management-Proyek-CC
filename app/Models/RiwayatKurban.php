<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKurban extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kurban';
    protected $primaryKey = 'id_riwayat_kurban';

    protected $fillable = [
        'id_kurban',
        'id_jamaah',
        'jenis_pembayaran',
        'jumlah_hewan',
        'jumlah_pembayaran',
        'tanggal_pembayaran',
        'status_pembayaran',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah_hewan' => 'integer',
        'jumlah_pembayaran' => 'decimal:2',
    ];

    // Relasi ke Kurban
    public function kurban()
    {
        return $this->belongsTo(Kurban::class, 'id_kurban');
    }

    // Relasi ke User (Jamaah)
    public function jamaah()
    {
        return $this->belongsTo(User::class, 'id_jamaah');
    }

    // Relasi ke Dokumentasi Kurban
    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiKurban::class, 'id_riwayat_kurban');
    }

    // Helper: Foto penyembelihan
    public function fotoPenyembelihan()
    {
        return $this->dokumentasi()->where('jenis_dokumentasi', 'penyembelihan')->get();
    }

    // Helper: Foto pembagian daging
    public function fotoPembagianDaging()
    {
        return $this->dokumentasi()->where('jenis_dokumentasi', 'pembagian_daging')->get();
    }
}

