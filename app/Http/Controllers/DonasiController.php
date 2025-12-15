<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\RiwayatDonasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index()
    {
        // Ambil data untuk Tab 1: Master Program
        $masterDonasi = Donasi::latest('tanggal_mulai')->get();
        
        // Ambil data untuk Tab 2: Riwayat Transaksi (Eager Load Relasi)
        $riwayatTransaksi = RiwayatDonasi::with(['jamaah', 'donasi'])
                            ->latest('tanggal_donasi')
                            ->get();

        // Pastikan view ini ada di folder resources/views/admin/donasi/index.blade.php
        return view('admin.donasi.index', compact('masterDonasi', 'riwayatTransaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_donasi' => 'required',
            'tanggal_mulai' => 'required|date',
        ]);

        Donasi::create($request->all());
        return back()->with('success', 'Program Donasi dibuat');
    }

    public function update(Request $request, $id)
    {
        $donasi = Donasi::findOrFail($id);
        $donasi->update($request->all());
        return back()->with('success', 'Program Donasi diperbarui');
    }

    public function destroy($id)
    {
        Donasi::destroy($id);
        return back()->with('success', 'Program dihapus');
    }
}