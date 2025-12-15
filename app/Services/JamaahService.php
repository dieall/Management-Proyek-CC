<?php

namespace App\Services;

use App\Models\Jamaah;
use App\Models\Kegiatan;
use App\Models\Donasi;
use App\Models\RiwayatDonasi; // Pakai Model Transaksi langsung
use App\Models\KeikutsertaanKegiatan; // Pakai Model Pivot langsung
use Illuminate\Support\Facades\DB;

class JamaahService
{
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = Jamaah::query();

        if (!empty($filters['username'])) {
            $query->where('username', 'like', '%' . $filters['username'] . '%');
        }

        if (!empty($filters['nama_lengkap'])) {
            $query->where('nama_lengkap', 'like', '%' . $filters['nama_lengkap'] . '%');
        }

        if (!empty($filters['kategori'])) {
            $query->whereHas('kategori', function ($q) use ($filters) {
                $q->where('kategori.id_kategori', $filters['kategori']);
            });
        }

        if (isset($filters['status_aktif'])) {
            $query->where('status_aktif', filter_var($filters['status_aktif'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->paginate($perPage);
    }

    public function getById(int $id): Jamaah
    {
        return Jamaah::findOrFail($id);
    }

    public function create(array $data): Jamaah
    {
        // FIX: Hapus Hash::make() karena Model Jamaah sudah cast 'kata_sandi' => 'hashed'
        // Data password raw akan otomatis di-hash oleh Eloquent
        
        $data['status_aktif'] = $data['status_aktif'] ?? true;
        return Jamaah::create($data);
    }

    public function update(Jamaah $jamaah, array $data): Jamaah
    {
        // Jika password kosong, hapus dari array agar tidak menimpa password lama dengan null/kosong
        if (empty($data['kata_sandi'])) {
            unset($data['kata_sandi']);
        }
        
        // Model akan otomatis handle hashing jika kata_sandi di-set
        $jamaah->update($data);
        return $jamaah;
    }

    public function delete(Jamaah $jamaah): bool
    {
        $jamaah->update(['status_aktif' => false]);
        return true;
    }

    public function syncKategori(Jamaah $jamaah, array $kategoriIds, ?string $periode = null)
    {
        $sync = [];
        foreach ($kategoriIds as $id) {
            $sync[$id] = [
                'status_aktif' => true,
                'periode' => $periode
            ];
        }
        return $jamaah->kategori()->sync($sync);
    }

    // OPTIMASI: Gunakan Model Pivot KeikutsertaanKegiatan
    public function daftarKegiatan(Jamaah $jamaah, int $idKegiatan, ?string $tanggalDaftar = null)
    {
        // Cek apakah sudah terdaftar
        $exists = KeikutsertaanKegiatan::where('id_jamaah', $jamaah->id_jamaah)
                    ->where('id_kegiatan', $idKegiatan)
                    ->exists();

        if ($exists) {
            return false; // Atau throw exception
        }

        return KeikutsertaanKegiatan::create([
            'id_jamaah' => $jamaah->id_jamaah,
            'id_kegiatan' => $idKegiatan,
            'tanggal_daftar' => $tanggalDaftar ?? now(),
            'status_kehadiran' => 'belum' // Default sesuai migration
        ]);
    }

    // OPTIMASI: Gunakan Model RiwayatDonasi langsung
    public function catatDonasi(Jamaah $jamaah, int $idDonasi, float $jumlah, ?string $tanggal = null)
    {
        // Menggunakan create langsung lebih aman untuk tabel transaksi
        return RiwayatDonasi::create([
            'id_jamaah' => $jamaah->id_jamaah,
            'id_donasi' => $idDonasi,
            'besar_donasi' => $jumlah,
            'tanggal_donasi' => $tanggal ?? now()
        ]);
    }
}