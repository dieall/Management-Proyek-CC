<?php

namespace App\Services;

use App\Models\Donasi;
use App\Models\Jamaah;
use App\Models\RiwayatDonasi;
use Illuminate\Database\Eloquent\Collection;

class DonasiService
{
    public function getAll(): Collection
    {
        return Donasi::all();
    }

    public function getById(int $id): ?Donasi
    {
        return Donasi::find($id);
    }

    public function create(array $data): Donasi
    {
        return Donasi::create($data);
    }

    public function update(Donasi $donasi, array $data): Donasi
    {
        $donasi->update($data);
        return $donasi;
    }

    public function delete(Donasi $donasi): void
    {
        $donasi->delete();
    }

    public function getJamaah(Donasi $donasi): Collection
    {
        // Mengambil data jamaah lewat relasi many-to-many
        return $donasi->donatur()->get(); 
    }

    public function catatDonasi(
        Donasi $donasi,
        Jamaah $jamaah,
        float $jumlah,
        ?string $tanggal = null
    ): void {
        // FIX: Gunakan RiwayatDonasi model agar lebih aman & clean
        RiwayatDonasi::create([
            'id_jamaah' => $jamaah->id_jamaah,
            'id_donasi' => $donasi->id_donasi,
            'besar_donasi' => $jumlah,
            'tanggal_donasi' => $tanggal ?? now(),
        ]);
    }
}