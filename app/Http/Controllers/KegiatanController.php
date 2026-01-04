<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin() || $user->isDkm()) {
            $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();
        } else {
            // Jamaah/Panitia hanya lihat kegiatan aktif
            $kegiatans = Kegiatan::where('status_kegiatan', 'aktif')
                                ->orderBy('tanggal', 'desc')
                                ->get();
        }
        
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_kegiatan' => 'required|in:aktif,selesai,batal',
        ]);

        Kegiatan::create($request->all());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load('peserta');
        
        // Statistik
        $totalPeserta = $kegiatan->peserta()->count();
        $hadir = $kegiatan->peserta()->wherePivot('status_kehadiran', 'hadir')->count();
        $izin = $kegiatan->peserta()->wherePivot('status_kehadiran', 'izin')->count();
        $alpa = $kegiatan->peserta()->wherePivot('status_kehadiran', 'alpa')->count();
        
        return view('kegiatan.show', compact('kegiatan', 'totalPeserta', 'hadir', 'izin', 'alpa'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_kegiatan' => 'required|in:aktif,selesai,batal',
        ]);

        $kegiatan->update($request->all());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }

    // Daftarkan peserta ke kegiatan
    public function daftar(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $user = auth()->user();

        // Cek apakah sudah terdaftar
        if ($kegiatan->peserta()->where('id_jamaah', $user->id)->exists()) {
            return back()->with('error', 'Anda sudah terdaftar di kegiatan ini!');
        }

        $kegiatan->peserta()->attach($user->id, [
            'tanggal_daftar' => now()->toDateString(),
            'status_kehadiran' => 'terdaftar',
        ]);

        return back()->with('success', 'Berhasil mendaftar kegiatan!');
    }

    // Update status kehadiran
    public function updateKehadiran(Request $request, $id)
    {
        $request->validate([
            'id_jamaah' => 'required|exists:users,id',
            'status_kehadiran' => 'required|in:terdaftar,hadir,izin,alpa',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        
        $kegiatan->peserta()->updateExistingPivot($request->id_jamaah, [
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return back()->with('success', 'Status kehadiran berhasil diperbarui!');
    }
}

