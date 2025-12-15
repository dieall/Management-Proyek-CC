<?php

namespace App\Services;

use App\Models\Kegiatan;
use App\Models\Jamaah;
use App\Models\KeikutsertaanKegiatan;
use Illuminate\Database\Eloquent\Collection;

class KegiatanService
{
    public function getAll(): Collection
    {
        return Kegiatan::all();
    }

    public function getById(int $id): ?Kegiatan
    {
        return Kegiatan::find($id);
    }

    public function create(array $data): Kegiatan
    {
        return Kegiatan::create($data);
    }

    public function update(Kegiatan $kegiatan, array $data): Kegiatan
    {
        $kegiatan->update($data);
        return $kegiatan;
    }

    public function delete(Kegiatan $kegiatan): void
    {
        $kegiatan->delete();
    }

    public function getPeserta(Kegiatan $kegiatan): Collection
    {
        return $kegiatan->jamaah()->get();
    }

    public function tambahPeserta(
        Kegiatan $kegiatan,
        Jamaah $jamaah,
        ?string $tanggalDaftar = null
    ): void {
        // Cek duplikasi dulu biar tidak error SQL
        $exists = KeikutsertaanKegiatan::where('id_jamaah', $jamaah->id_jamaah)
                    ->where('id_kegiatan', $kegiatan->id_kegiatan)
                    ->exists();
        
        if (!$exists) {
            KeikutsertaanKegiatan::create([
                'id_jamaah' => $jamaah->id_jamaah,
                'id_kegiatan' => $kegiatan->id_kegiatan,
                'tanggal_daftar' => $tanggalDaftar ?? now(),
                'status_kehadiran' => 'belum',
            ]);
        }
    }

    public function ubahStatusKehadiran(
        Kegiatan $kegiatan,
        Jamaah $jamaah,
        string $status
    ): void {
        // Update langsung ke tabel pivot menggunakan Model Pivot
        KeikutsertaanKegiatan::where('id_jamaah', $jamaah->id_jamaah)
            ->where('id_kegiatan', $kegiatan->id_kegiatan)
            ->update(['status_kehadiran' => $status]);
    }
}