<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPerawatan;
use App\Models\JadwalPerawatan;
use App\Models\Aset;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanPerawatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $laporan = LaporanPerawatan::with('aset', 'user', 'jadwalPerawatan')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->paginate(10);
        
        return view('laporan-perawatan.index', compact('laporan', 'user'));
    }

    public function create(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $jadwal = $jadwalId ? JadwalPerawatan::with('aset')->findOrFail($jadwalId) : null;
        $aset = Aset::active()->orderBy('nama_aset')->get();
        $jadwalList = JadwalPerawatan::where('status', '!=', 'selesai')
            ->with('aset')
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();
        
        return view('laporan-perawatan.create', compact('jadwal', 'aset', 'jadwalList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_perawatan_id' => 'nullable|exists:jadwal_perawatan,id',
            'aset_id' => 'required|exists:aset,id',
            'tanggal_pemeriksaan' => 'required|date',
            'kondisi_sebelum' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'kondisi_sesudah' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'hasil_pemeriksaan' => 'required|string',
            'tindakan' => 'nullable|string',
            'biaya_perawatan' => 'nullable|numeric|min:0',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        // Handle foto upload
        if ($request->hasFile('foto_sebelum')) {
            $foto = $request->file('foto_sebelum');
            $fotoName = time() . '_sebelum_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('laporan', $fotoName, 'public'); // storage/app/public/laporan
            $validated['foto_sebelum'] = $path; // laporan/xxx.jpg
        }

        if ($request->hasFile('foto_sesudah')) {
            $foto = $request->file('foto_sesudah');
            $fotoName = time() . '_sesudah_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('laporan', $fotoName, 'public');
            $validated['foto_sesudah'] = $path;
        }

        $laporan = LaporanPerawatan::create($validated);

        // Update kondisi aset
        $aset = Aset::findOrFail($validated['aset_id']);
        $aset->update(['kondisi' => $validated['kondisi_sesudah']]);

        // Update status jadwal jika ada
        if ($validated['jadwal_perawatan_id']) {
            $jadwal = JadwalPerawatan::findOrFail($validated['jadwal_perawatan_id']);
            $jadwal->update(['status' => 'selesai']);
        }

        $this->logAktivitas('create', $laporan, null, $laporan->toArray());

        return redirect()->route('laporan-perawatan.index')->with('success', 'Laporan perawatan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $laporan = LaporanPerawatan::with('aset', 'user', 'jadwalPerawatan')->findOrFail($id);
        return view('laporan-perawatan.show', compact('laporan'));
    }

    public function edit(string $id)
    {
        $laporan = LaporanPerawatan::findOrFail($id);
        $aset = Aset::active()->orderBy('nama_aset')->get();
        $jadwalList = JadwalPerawatan::where('status', '!=', 'selesai')
            ->with('aset')
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();
        
        return view('laporan-perawatan.edit', compact('laporan', 'aset', 'jadwalList'));
    }

    public function update(Request $request, string $id)
    {
        $laporan = LaporanPerawatan::findOrFail($id);
        $oldData = $laporan->toArray();

        $validated = $request->validate([
            'jadwal_perawatan_id' => 'nullable|exists:jadwal_perawatan,id',
            'aset_id' => 'required|exists:aset,id',
            'tanggal_pemeriksaan' => 'required|date',
            'kondisi_sebelum' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'kondisi_sesudah' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'hasil_pemeriksaan' => 'required|string',
            'tindakan' => 'nullable|string',
            'biaya_perawatan' => 'nullable|numeric|min:0',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto_sebelum')) {
            if ($laporan->foto_sebelum) {
                Storage::disk('public')->delete($laporan->foto_sebelum);
            }
            $foto = $request->file('foto_sebelum');
            $fotoName = time() . '_sebelum_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('laporan', $fotoName, 'public');
            $validated['foto_sebelum'] = $path;
        }

        if ($request->hasFile('foto_sesudah')) {
            if ($laporan->foto_sesudah) {
                Storage::disk('public')->delete($laporan->foto_sesudah);
            }
            $foto = $request->file('foto_sesudah');
            $fotoName = time() . '_sesudah_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('laporan', $fotoName, 'public');
            $validated['foto_sesudah'] = $path;
        }

        $laporan->update($validated);

        // Update kondisi aset
        $aset = Aset::findOrFail($validated['aset_id']);
        $aset->update(['kondisi' => $validated['kondisi_sesudah']]);

        $this->logAktivitas('update', $laporan, $oldData, $laporan->fresh()->toArray());

        return redirect()->route('laporan-perawatan.index')->with('success', 'Laporan perawatan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $laporan = LaporanPerawatan::findOrFail($id);
        $oldData = $laporan->toArray();

        // Hapus foto jika ada
        if ($laporan->foto_sebelum) {
            Storage::disk('public')->delete($laporan->foto_sebelum);
        }
        if ($laporan->foto_sesudah) {
            Storage::disk('public')->delete($laporan->foto_sesudah);
        }

        $laporan->delete();

        $this->logAktivitas('delete', $laporan, $oldData, null);

        return redirect()->route('laporan-perawatan.index')->with('success', 'Laporan perawatan berhasil dihapus.');
    }

    private function logAktivitas($action, $model, $oldData = null, $newData = null)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'description' => "Laporan Perawatan {$action}",
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
