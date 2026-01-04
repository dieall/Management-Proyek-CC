<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPerawatan;
use App\Models\Aset;
use App\Models\LogAktivitas;

class JadwalPerawatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $jadwal = JadwalPerawatan::with('aset', 'user')
            ->orderBy('tanggal_jadwal', 'asc')
            ->paginate(10);
        
        return view('jadwal-perawatan.index', compact('jadwal', 'user'));
    }

    public function create()
    {
        $aset = Aset::active()->orderBy('nama_aset')->get();
        return view('jadwal-perawatan.create', compact('aset'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aset_id' => 'required|exists:aset,id',
            'jenis_perawatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_jadwal' => 'required|date',
            'status' => 'required|in:terjadwal,sedang_dilakukan,selesai,dibatalkan',
        ]);

        $validated['user_id'] = auth()->id();
        $jadwal = JadwalPerawatan::create($validated);

        $this->logAktivitas('create', $jadwal, null, $jadwal->toArray());

        return redirect()->route('jadwal-perawatan.index')->with('success', 'Jadwal perawatan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $jadwal = JadwalPerawatan::with('aset', 'user', 'laporanPerawatan')->findOrFail($id);
        return view('jadwal-perawatan.show', compact('jadwal'));
    }

    public function edit(string $id)
    {
        $jadwal = JadwalPerawatan::findOrFail($id);
        $aset = Aset::active()->orderBy('nama_aset')->get();
        return view('jadwal-perawatan.edit', compact('jadwal', 'aset'));
    }

    public function update(Request $request, string $id)
    {
        $jadwal = JadwalPerawatan::findOrFail($id);
        $oldData = $jadwal->toArray();

        $validated = $request->validate([
            'aset_id' => 'required|exists:aset,id',
            'jenis_perawatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_jadwal' => 'required|date',
            'status' => 'required|in:terjadwal,sedang_dilakukan,selesai,dibatalkan',
        ]);

        $jadwal->update($validated);

        $this->logAktivitas('update', $jadwal, $oldData, $jadwal->fresh()->toArray());

        return redirect()->route('jadwal-perawatan.index')->with('success', 'Jadwal perawatan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $jadwal = JadwalPerawatan::findOrFail($id);
        $oldData = $jadwal->toArray();
        
        $jadwal->delete();

        $this->logAktivitas('delete', $jadwal, $oldData, null);

        return redirect()->route('jadwal-perawatan.index')->with('success', 'Jadwal perawatan berhasil dihapus.');
    }

    private function logAktivitas($action, $model, $oldData = null, $newData = null)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'description' => "Jadwal Perawatan {$action}",
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
