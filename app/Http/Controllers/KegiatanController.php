<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KeikutsertaanKegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        // Ambil Master Data Kegiatan
        $masterKegiatan = Kegiatan::latest('tanggal')->get();

        // Ambil Data Peserta/Presensi
        $peserta = KeikutsertaanKegiatan::with(['jamaah', 'kegiatan'])
                   ->latest('tanggal_daftar')
                   ->get();

        return view('admin.kegiatan.index', compact('masterKegiatan', 'peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required', // Pastikan nama kolom di DB 'nama_kegiatan'
            'tanggal' => 'required|date',
        ]);

        Kegiatan::create($request->all());
        return back()->with('success', 'Kegiatan berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($request->all());
        return back()->with('success', 'Kegiatan diperbarui');
    }

    public function destroy($id)
    {
        Kegiatan::destroy($id);
        return back()->with('success', 'Kegiatan dihapus');
    }
}