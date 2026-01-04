<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\AsetArchive;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Aset::query();

        // Filter berdasarkan status archive
        if ($request->has('status')) {
            if ($request->status === 'archived') {
                $query->archived();
            } else {
                $query->active();
            }
        } else {
            $query->active();
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                  ->orWhere('kode_aset', 'like', "%{$search}%")
                  ->orWhere('jenis_aset', 'like', "%{$search}%");
            });
        }

        $aset = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('aset.index', compact('aset', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureAdmin();
        return view('aset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'kode_aset' => 'required|unique:aset,kode_aset',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'lokasi' => 'nullable|string|max:255',
            'sumber_perolehan' => 'required|in:pembelian,donasi',
            'harga' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'nilai_donasi' => 'nullable|numeric|min:0',
            'donatur' => 'nullable|string|max:255',
            'tanggal_donasi' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            // simpan ke disk public/aset (storage/app/public/aset)
            $path = $foto->storeAs('aset', $fotoName, 'public');
            $validated['foto'] = $path; // contoh: aset/abc.jpg
        }

        $aset = Aset::create($validated);

        // Log aktivitas
        $this->logAktivitas('create', $aset, null, $aset->toArray());

        return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aset = Aset::findOrFail($id);
        $user = auth()->user();

        // Jika user bukan admin, sembunyikan data sensitif
        if (!$user->isAdmin()) {
            $aset->makeHidden(['harga', 'vendor', 'tanggal_pembelian']);
        }

        $jadwalPerawatan = $aset->jadwalPerawatan()->orderBy('tanggal_jadwal', 'desc')->get();
        $laporanPerawatan = $aset->laporanPerawatan()->orderBy('tanggal_pemeriksaan', 'desc')->get();

        return view('aset.show', compact('aset', 'user', 'jadwalPerawatan', 'laporanPerawatan'));
    }

    /**
     * QR code untuk detail aset.
     */
    public function qr(string $id)
    {
        $aset = Aset::findOrFail($id);
        $url = route('aset.show', $aset->id);
        return view('aset.qr', compact('aset', 'url'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aset = Aset::findOrFail($id);
        $this->ensureAdmin();
        return view('aset.edit', compact('aset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $aset = Aset::findOrFail($id);
        $this->ensureAdmin();
        $oldData = $aset->toArray();

        $validated = $request->validate([
            'kode_aset' => 'required|unique:aset,kode_aset,' . $id,
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak',
            'lokasi' => 'nullable|string|max:255',
            'sumber_perolehan' => 'required|in:pembelian,donasi',
            'harga' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'nilai_donasi' => 'nullable|numeric|min:0',
            'donatur' => 'nullable|string|max:255',
            'tanggal_donasi' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($aset->foto) {
                Storage::disk('public')->delete($aset->foto);
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('aset', $fotoName, 'public');
            $validated['foto'] = $path;
        }

        $aset->update($validated);

        // Log aktivitas
        $this->logAktivitas('update', $aset, $oldData, $aset->fresh()->toArray());

        return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui.');
    }

    /**
     * Archive the specified resource.
     */
    public function archive(Request $request, string $id)
    {
        $aset = Aset::findOrFail($id);
        $this->ensureAdmin();
        $oldData = $aset->toArray();

        // Simpan ke archive
        AsetArchive::create([
            'aset_id' => $aset->id,
            'kode_aset' => $aset->kode_aset,
            'nama_aset' => $aset->nama_aset,
            'jenis_aset' => $aset->jenis_aset,
            'deskripsi' => $aset->deskripsi,
            'kondisi' => $aset->kondisi,
            'lokasi' => $aset->lokasi,
            'sumber_perolehan' => $aset->sumber_perolehan,
            'harga' => $aset->harga,
            'vendor' => $aset->vendor,
            'tanggal_pembelian' => $aset->tanggal_pembelian,
            'nilai_donasi' => $aset->nilai_donasi,
            'donatur' => $aset->donatur,
            'tanggal_donasi' => $aset->tanggal_donasi,
            'foto' => $aset->foto,
            'archived_by' => auth()->id(),
            'alasan_archive' => $request->alasan_archive,
            'archived_at' => now(),
        ]);

        // Update status archive
        $aset->update(['is_archived' => true]);

        // Log aktivitas
        $this->logAktivitas('archive', $aset, $oldData, $aset->fresh()->toArray(), $request->alasan_archive);

        return redirect()->route('aset.index')->with('success', 'Aset berhasil di-archive.');
    }

    /**
     * Restore archived resource.
     */
    public function restore(string $id)
    {
        $asetArchive = AsetArchive::where('aset_id', $id)->latest()->first();
        
        if (!$asetArchive) {
            return redirect()->route('aset.index')->with('error', 'Data archive tidak ditemukan.');
        }

        $aset = Aset::findOrFail($id);
        $this->ensureAdmin();
        $oldData = $aset->toArray();

        // Restore data dari archive
        $aset->update([
            'kode_aset' => $asetArchive->kode_aset,
            'nama_aset' => $asetArchive->nama_aset,
            'jenis_aset' => $asetArchive->jenis_aset,
            'deskripsi' => $asetArchive->deskripsi,
            'kondisi' => $asetArchive->kondisi,
            'lokasi' => $asetArchive->lokasi,
            'sumber_perolehan' => $asetArchive->sumber_perolehan,
            'harga' => $asetArchive->harga,
            'vendor' => $asetArchive->vendor,
            'tanggal_pembelian' => $asetArchive->tanggal_pembelian,
            'nilai_donasi' => $asetArchive->nilai_donasi,
            'donatur' => $asetArchive->donatur,
            'tanggal_donasi' => $asetArchive->tanggal_donasi,
            'foto' => $asetArchive->foto,
            'is_archived' => false,
        ]);

        // Log aktivitas
        $this->logAktivitas('restore', $aset, $oldData, $aset->fresh()->toArray());

        return redirect()->route('aset.index')->with('success', 'Aset berhasil di-restore.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tidak ada destroy permanen, gunakan archive
        return $this->archive(request()->merge(['alasan_archive' => 'Dihapus oleh admin']), $id);
    }

    /**
     * Log aktivitas helper
     */
    private function logAktivitas($action, $model, $oldData = null, $newData = null, $description = null)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'description' => $description ?? "Aset {$action}: {$model->nama_aset}",
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Pastikan hanya admin yang boleh create/update/archive/restore aset.
     */
    private function ensureAdmin(): void
    {
        $user = auth()->user();
        if (!$user || !($user->isAdminOrSuper())) {
            abort(403, 'Hanya admin/superadmin yang diperbolehkan.');
        }
    }
}
