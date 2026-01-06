<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurban extends Model
{
    use HasFactory;

    protected $table = 'kurban';
    protected $primaryKey = 'id_kurban';

    protected $fillable = [
        'nama_kurban',
        'tanggal_kurban',
        'jenis_hewan',
        'target_hewan',
        'harga_per_hewan',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tanggal_kurban' => 'date',
        'target_hewan' => 'integer',
        'harga_per_hewan' => 'decimal:2',
    ];

    // Relasi Many-to-Many dengan Users (Jamaah) melalui riwayat_kurban
    public function peserta()
    {
        return $this->belongsToMany(User::class, 'riwayat_kurban', 'id_kurban', 'id_jamaah')
                    ->withPivot('jenis_pembayaran', 'jumlah_hewan', 'jumlah_pembayaran', 'tanggal_pembayaran', 'status_pembayaran', 'keterangan')
                    ->withTimestamps();
    }

    // Relasi ke riwayat_kurban
    public function riwayatKurban()
    {
        return $this->hasMany(RiwayatKurban::class, 'id_kurban');
    }

    // Helper: Total hewan yang sudah terdaftar
    public function totalHewanTerdaftar()
    {
        return $this->riwayatKurban()->sum('jumlah_hewan');
    }

    // Helper: Total pembayaran yang sudah diterima
    public function totalPembayaran()
    {
        return $this->riwayatKurban()->sum('jumlah_pembayaran');
    }

    // Helper: Sisa hewan yang masih bisa didaftarkan
    public function sisaHewan()
    {
        return max(0, $this->target_hewan - $this->totalHewanTerdaftar());
    }

    // Helper: Jumlah peserta
    public function jumlahPeserta()
    {
        return $this->riwayatKurban()->distinct('id_jamaah')->count();
    }
}

